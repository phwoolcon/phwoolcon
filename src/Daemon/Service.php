<?php
namespace Phwoolcon\Daemon;

use Closure;
use Phalcon\Events\Event;
use Phalcon\Http\Response;
use Phwoolcon\Cli\Command;
use Phwoolcon\Cookies;
use Phwoolcon\Events;
use Phwoolcon\Router;
use Phwoolcon\Session;
use Phwoolcon\View;
use swoole_server;
use ErrorException;
use Phalcon\Di;
use Phwoolcon\Config;

class Service
{
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var Command
     */
    protected $serviceCommand;
    protected $config;
    protected $runDir = '/tmp/phwoolcon/';
    protected $debug = false;
    protected $profilerDir;
    protected $initScript;
    protected $name;

    /**
     * @var swoole_server
     */
    protected $swoole;
    protected $swoolePort;
    protected $availablePorts = [9502, 9503];
    protected $sockFile;
    protected $pid;
    protected $managerPid;

    protected $commandServer;
    protected $environmentVariables = [];

    /**
     * @var ServiceAwareInterface[]
     */
    protected $serviceAwareComponents = [];
    protected $debugData = [];

    public function __construct($config)
    {
        // @codeCoverageIgnoreStart
        if (PHP_SAPI != 'cli') {
            throw new ErrorException('Service is designed to be run in CLI mode only.');
        }
        if (!class_exists('swoole_server', false)) {
            throw new ErrorException('PHP extension swoole not installed!');
        }
        // @codeCoverageIgnoreEnd

        foreach ($_SERVER as $k => $v) {
            substr($k, 0, 10) == 'PHWOOLCON_' and $this->environmentVariables[$k] = $v;
        }

        $this->config = $config;
        $this->runDir = $config['run_dir'];
        $this->debug = $config['debug'];
        substr($this->runDir, -1) == '/' or $this->runDir .= '/';
        is_dir($this->runDir) or mkdir($this->runDir, 0777, true);
        is_dir($this->profilerDir = storagePath('profiler')) or mkdir($this->profilerDir, 0777, true);

        $this->initScript = $this->config['linux_init_script'];
        $this->name = basename($this->initScript);
    }

    /**
     * Choose a port in [9502, 9503] to serve
     *
     * @param bool $swap True to swap port, otherwise remain previous port
     * @return integer Return previous port
     */
    public function choosePort($swap = false)
    {
        $portSaved = is_file($portFile = $this->runDir . 'service-port.php');
        $port = $previousPort = ($portSaved ? include($portFile) : reset($this->availablePorts));
        if ($swap) {
            $portSaved = false;
            foreach ($this->availablePorts as $port) {
                if ($port != $previousPort) {
                    break;
                }
            }
        }
        $this->swoolePort = $port;
        $this->sockFile = $this->runDir . 'service-' . $port . '.sock';
        $portSaved or file_put_contents($portFile, sprintf('<?php return %d;', $port));
        return $previousPort;
    }

    protected function getDebugInfo(swoole_server $server)
    {
        return [
            'service' => 1,
            'mem' => round(memory_get_usage() / 1024 / 1024, 2) . 'M',
            'worker-id' => $server->worker_id,
            'status' => json_encode($server->stats()),
        ] + $this->debugData;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Get service info, including pid, manager pid and port
     *
     * @param string $instance Specify instance name (e.g. "current", "old").
     *                         If not specified, return combined info of all instances.
     * @return array An array containing service info
     */
    protected function getServiceInfo($instance = null)
    {
        $file = $this->runDir . 'service-info.php';
        $info = is_file($file) ? include($file) : [];
        return $instance ? fnGet($info, $instance, []) : $info;
    }

    protected function initSwoole()
    {
        $this->choosePort();
        $server = $this->swoole = new swoole_server($this->sockFile, 0, SWOOLE_PROCESS, SWOOLE_UNIX_STREAM);
        $config = array_merge([
            /**
             * Dispatch mode
             * @see http://wiki.swoole.com/wiki/page/277.html
             */
            'dispatch_mode' => 2,
            'log_file' => storagePath('logs/service.log'),

            /**
             * Content detect protocol
             * @see http://wiki.swoole.com/wiki/page/484.html
             */
            'open_length_check' => true,
            'package_max_length' => 262144,
            'package_length_type' => 'N',
            'package_length_offset' => 0,
            'package_body_offset' => 4,
        ], $this->config);
        unset($config['run_dir'], $config['linux_init_script'], $config['debug'], $config['start_on_boot']);
        unset($config['profiler']);
        $server->set($config);

        $enableProfiler = $this->config['profiler'] && function_exists('xhprof_enable');
        $server->on('Start', [$this, 'onStart']);
        $server->on('Shutdown', [$this, 'onShutdown']);
        $server->on('ManagerStart', [$this, 'onManagerStart']);
        $server->on('WorkerStart', [$this, 'onWorkerStart']);
        $server->on('Receive', [$this, $enableProfiler ? 'profileReceive' : 'onReceive']);
    }

    public function onManagerStart(swoole_server $server)
    {
        @cli_set_process_title($this->name . ': manager process');
    }

    public function onReceive(swoole_server $server, $fd, $fromId, $data)
    {
        $length = unpack('N', $data)[1];
        $data = unserialize(substr($data, -$length));

        $_REQUEST = $_GET = $_POST = isset($data['request']) ? $data['request'] : [];
        $_COOKIE = isset($data['cookies']) ? $data['cookies'] : [];
        $_FILES = isset($data['files']) ? $data['files'] : [];
        $_SERVER = isset($data['server']) ? $data['server'] : [];
        foreach ($this->environmentVariables as $k => $v) {
            $_SERVER[$k] = $v;
        }
        $this->reset();
        $this->debug and $this->debugData = [];
        ob_start();
        $response = Router::dispatch();
        $extraContent = ob_get_clean();
        $headers = $this->parseResponseHeaders($response);
        $body = $response->getContent();
        $result = serialize([
            'headers' => $headers,
            'body' => $body . $extraContent,
            'meta' => $this->debug ? $this->getDebugInfo($server) : ['service' => 1],
        ]);

        $packageHead = pack('N', strlen($result));
        $server->send($fd, $packageHead . $result, $fromId);
    }

    public function onShutdown(swoole_server $server)
    {
        swoole_event_del($this->commandServer);
    }

    /**
     * Callback after service started
     * @param swoole_server $server
     */
    public function onStart(swoole_server $server)
    {
        @cli_set_process_title($this->name . ': master process/reactor threads; port=' . $this->swoolePort);
        // Send SIGTERM to master pid to shutdown service
        $this->pid = $server->master_pid;
        // Send SIGUSR1 to master pid to reload workers
        $this->managerPid = $server->manager_pid;

        $this->startCommandHandler();

        $this->updateServiceInfo('current', [
            'pid' => $this->pid,
            'manager_pid' => $this->managerPid,
            'port' => $this->swoolePort,
        ]);
        $this->serviceCommand->info("pid = {$this->pid}; port = {$this->swoolePort}");
        $this->serviceCommand->info('Service started.');
    }

    public function onWorkerStart(swoole_server $server, $workerId)
    {
        @cli_set_process_title($this->name . ': worker process ' . $workerId);
    }

    protected function parseResponseHeaders(Response $response)
    {
        $headers = ['status' => '', 'headers' => [], 'set_cookies' => []];
        // status
        $headers['status'] = 'HTTP/1.1 ' . $response->getStatusCode();

        // headers
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                $headers['headers'][] = $name . ': ' . $value;
            }
        }

        // cookies
        foreach (Cookies::toArray() as $cookie) {
            $headers['set_cookies'][] = [
                $cookie->getName(),
                $cookie->getResponseValue(),
                $cookie->getExpiration(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->getSecure(),
                $cookie->getHttpOnly(),
            ];
        }
        return $headers;
    }

    protected function prepareDebugObservers()
    {
        Events::attach('router:after_dispatch', function (Event $event) {
            $this->debugData['session-id'] = json_encode(Session::getId());
            $this->debugData['session-data'] = json_encode($_SESSION);
        });
    }

    /**
     * Resolve service aware components
     * Each component will be reset before every request is handled
     */
    protected function prepareServiceAwareComponents()
    {
        /* @var Di\Service $service */
        foreach (static::$di->getServices() as $name => $service) {
            if (!$service->isShared()) {
                continue;
            }
            $component = static::$di->getShared($name);
            if ($component instanceof ServiceAwareInterface) {
                $this->serviceAwareComponents[$name] = $component;
            }
        }
        // Listen for further components
        Events::attach('di:afterServiceResolve', Closure::bind(function (Event $event) {
            $data = $event->getData();
            $name = $data['name'];
            $component = $data['instance'];
            if ($component instanceof ServiceAwareInterface) {
                $this->serviceAwareComponents[$name] = $component;
            }
        }, $this));
    }

    /**
     * @param string $command
     * @return string Process result
     */
    protected function processCommand($command)
    {
        $server = $this->swoole;
        switch ($command) {
            case 'status':
                $labels = [
                    'start_time' => 'Service started at',
                    'connection_num' => 'Current connections',
                    'request_count' => 'Total requests',
                ];
                $stats = $server->stats();
                $result = "Service is running. PID: {$server->master_pid}, port: {$this->swoolePort}";
                $result .= "\nSwoole version: " . swoole_version();
                foreach ($labels as $k => $label) {
                    $v = $stats[$k];
                    $k == 'start_time' and $v = date('Y-n-j H:i:s (e)', $v);
                    $result .= "\n{$label}: {$v}";
                }
                $result .= "\nWorkers: {$this->config['worker_num']}";
                break;
            case 'connections':
                $stats = $server->stats();
                $result = $stats['connection_num'];
                break;
            case 'shutdown':
            default:
                $result = 'Bad command';
        }
        return $result;
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('service');
        $di->setShared('service', function () {
            return new static(Config::get('service'));
        });
    }

    public function reset()
    {
        foreach ($this->serviceAwareComponents as $component) {
            $component->reset();
        }
    }

    /**
     * Send command to service command handler
     *
     * @param string $command
     * @param integer $port
     * @param         $error
     * @return string
     */
    public function sendCommand($command, $port = null, &$error = null)
    {
        $port or $port = $this->choosePort();
        $sockFile = $this->runDir . "command-{$port}.sock";
        if (!$socket = @stream_socket_client('unix://' . $sockFile, $errNo, $errStr, 5)) {
            $error = ['err' => $errNo, 'message' => $errStr];
            return "$errStr ($errNo)";
        } else {
            $error = false;
            fwrite($socket, $command, strlen($command));
            $response = fread($socket, 8192);
            fclose($socket);
            return $response;
        }
    }

    public function setServiceCommand(Command $command)
    {
        $this->serviceCommand = $command;
        return $this;
    }

    /**
     * Mark running instance as old
     *
     * @return $this
     */
    public function shift()
    {
        $this->updateServiceInfo('shift');
        $this->choosePort(true);
        return $this;
    }

    public function showStatus()
    {
        $response = $this->sendCommand('status', null, $error);
        $error ? $this->serviceCommand->error('Service not started.') : $this->serviceCommand->info($response);
        exit($error ? 3 : 0);
    }

    public function start()
    {
        $port = $this->choosePort();
        $this->sendCommand('status', $port, $error);
        if (!$error) {
            $this->serviceCommand->error('Service already started');
            return;
        }
        $this->prepareServiceAwareComponents();
        $this->debug and $this->prepareDebugObservers();
        $this->initSwoole();
        $this->swoole->start();
    }

    protected function startCommandHandler()
    {
        $sockFile = $this->runDir . "command-{$this->swoolePort}.sock";
        file_exists($sockFile) and unlink($sockFile);
        ini_set('html_errors', 0);
        if (!$this->commandServer = stream_socket_server('unix://' . $sockFile, $errNo, $errStr)) {
            $this->serviceCommand->error("Command handler start failed: {$errStr} ({$errNo})");
        } else {
            swoole_event_add($this->commandServer, function () {
                $conn = stream_socket_accept($this->commandServer, 0);
                swoole_event_add($conn, function ($conn) {
                    $command = fread($conn, 128);
                    $result = $this->processCommand($command);
                    swoole_event_write($conn, $result);
                    swoole_event_del($conn);
                });
            });
            $this->serviceCommand->info('Command handler started.');
        }
    }

    /**
     * Stop service
     * @param string $instance Specify "current" or "old". "current" by default.
     */
    public function stop($instance = 'current')
    {
        // Get (current or old) service info
        if ($serviceInfo = $this->getServiceInfo($instance)) {
            list($pid, $managerPid, $port) = array_values($serviceInfo);
            // Get serving connection numbers
            $connections = $this->sendCommand('connections', $port, $error);
            while (!$error && $connections > 0) {
                usleep(5e5);
                $connections = $this->sendCommand('connections', $port, $error);
            }
            // Send TERM signal to master process to stop service
            posix_kill($pid, SIGTERM);
            // Kill master process in Mac OS
            if (PHP_OS == 'Darwin') {
                sleep(1);
                posix_kill($pid, SIGKILL);
            }
        }
        $this->serviceCommand->info('Service stopped.');
    }

    protected function updateServiceInfo($key, $data = null)
    {
        $info = $this->getServiceInfo();
        if ($key == 'shift') {
            if (isset($info['current'])) {
                $info['old'] = $info['current'];
                unset($info['current']);
            }
        } elseif ($data === null) {
            unset($info[$key]);
        } else {
            $info[$key] = $data;
        }
        $file = $this->runDir . 'service-info.php';
        file_put_contents($file, sprintf('<?php return %s;', var_export($info, true)));
        // Reset opcache and stat cache
        opcache_reset();
        clearstatcache();
        return $this;
    }
}
