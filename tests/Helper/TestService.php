<?php
namespace Phwoolcon\Tests\Helper;

use Exception;
use Phwoolcon\Daemon\Service;
use Phwoolcon\Db;
use Phwoolcon\Log;
use Swoole\Process as SwooleProcess;
use Swoole\Server as SwooleServer;

class TestService extends Service
{
    /**
     * @var \Phwoolcon\Tests\Unit\Daemon\ServiceTest
     */
    protected $testCase;
    protected $workerStarted;

    public function __construct($config)
    {
        $this->workerStarted = storagePath('service-worker-started.php');
        parent::__construct($config);
    }

    public function deleteSockFile()
    {
        $this->choosePort();
        is_file($this->sockFile) and unlink($this->sockFile);
    }

    public function getRunDir()
    {
        return $this->runDir;
    }

    public function isWorkerStarted()
    {
        return include($this->workerStarted);
    }

    protected function initSwoole()
    {
        parent::initSwoole();
        $server = $this->swoole;
        $server->on('WorkerStop', [$this, 'onWorkerStop']);
        $server->on('ManagerStop', [$this, 'onManagerStop']);
    }

    public function onManagerStart(SwooleServer $server)
    {
        parent::onManagerStart($server);
        Log::debug(posix_getpid() . ' onManagerStart ' . $this->swoolePort);
    }

    public function onManagerStop(SwooleServer $server)
    {
        Log::debug(posix_getpid() . ' onManagerStop ' . $this->swoolePort);
        $this->testCase and $this->testCase->writeRemoteCoverage();
    }

    public function onShutdown(SwooleServer $server)
    {
        parent::onShutdown($server);
        Log::debug($this->pid . ' onShutdown ' . $this->swoolePort);
        $this->testCase and $this->testCase->writeRemoteCoverage();
    }

    public function onStart(SwooleServer $server)
    {
        parent::onStart($server);
        Log::debug($this->pid . ' onStart ' . $this->swoolePort);
    }

    public function onWorkerStart(SwooleServer $server, $workerId)
    {
        parent::onWorkerStart($server, $workerId);
        $this->setWorkerStarted();
        Log::debug(posix_getpid() . ' onWorkerStart ' . $this->swoolePort);
    }

    public function onWorkerStop(SwooleServer $server, $workerId)
    {
        Log::debug(posix_getpid() . ' onWorkerStop ' . $this->swoolePort);
        $this->testCase and $this->testCase->writeRemoteCoverage();
    }

    /**
     * @param \Phwoolcon\Tests\Unit\Daemon\ServiceTest $testCase
     * @return $this
     */
    public function setTestCase($testCase)
    {
        $this->testCase = $testCase;
        return $this;
    }

    public function setWorkerStarted($flag = true)
    {
        fileSaveArray($this->workerStarted, $flag);
    }

    public function start($dryRun = false)
    {
        try {
            $dryRun or Log::debug('Starting...');
            return parent::start($dryRun);
        } catch (Exception $e) {
            Log::exception($e);
        }
        return false;
    }

    public function startIsolated()
    {
        $this->setWorkerStarted(false);
        $serverProcess = new SwooleProcess(function () {
            $this->start();
        }, true);
        $serverProcess->start();
        Db::reconnect();

        $retry = 20;
        while ($retry && !$this->isWorkerStarted()) {
            usleep(1e5);
            --$retry;
        }
        $this->isWorkerStarted() or Log::error('Failed to start');

        return $serverProcess;
    }

    public function stop($instance = 'current')
    {
        parent::stop($instance);
        if ($serviceInfo = $this->getServiceInfo($instance)) {
            list(, , $port) = array_values($serviceInfo);

            $this->showStatus($port, false, $error);
            $retry = 10;
            while (!$error) {
                usleep(1e5);
                $this->showStatus($port, false, $error);
                --$retry;
            }
            $error or Log::error('Unable to stop instance: ' . $instance);
        }
    }
}
