<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phwoolcon\Queue\AdapterInterface;
use Phwoolcon\Queue\AdapterTrait;
use Phwoolcon\Queue\Exception;

class Queue
{
    /**
     * @var Di
     */
    protected static $di;

    /**
     * @var static
     */
    static protected $queue;
    protected $config;
    /**
     * @var AdapterTrait[]|AdapterInterface[]
     */
    protected $connections = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @return AdapterTrait|AdapterInterface
     */
    protected function connect($name)
    {
        $queue = $this->config['queues'][$name];
        $connectionName = $queue['connection'];
        $connection = $this->config['connections'][$connectionName];
        $options = array_merge($connection, $queue['options']);
        $class = $connection['adapter'];
        strpos($class, '\\') === false and $class = 'Phwoolcon\\Queue\\Adapter\\' . $class;
        $instance = new $class($options);
        if (!$instance instanceof AdapterInterface) {
            throw new Exception('Queue adapter class should implement ' . AdapterInterface::class);
        }
        return $instance;
    }

    public static function connection($name = null)
    {
        static::$queue === null and static::$queue = static::$di->getShared('queue');
        $queue = static::$queue;
        $name = $name ?: $queue->config['default'];

        if (!isset($queue->connections[$name])) {
            $queue->connections[$name] = $queue->connect($name);
        }

        return $queue->connections[$name];
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->setShared('queue', function () {
            return new static(Config::get('queue'));
        });
    }
}
