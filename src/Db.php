<?php

namespace Phwoolcon;

use Phalcon\Events\Event;
use Phwoolcon\Exception\InvalidConfigException;
use Phwoolcon\Model\MetaData\InCache;
use Phalcon\Di;
use Phalcon\Db as PhalconDb;
use Phalcon\Db\Adapter\Pdo as Adapter;

class Db extends PhalconDb
{
    /**
     * @var Di
     */
    protected static $di;

    /**
     * @var static
     */
    protected static $instance;

    protected static $defaultTableCharset = [];

    /**
     * @var Adapter[]|Db\Adapter\Pdo\Mysql[]
     */
    protected $connections = [];
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $ormOptions = $config['orm_options'];
        $ormOptions['distributed'] = $config['distributed'];
        Model::setup($ormOptions);
        if (fnGet($this->config, 'query_log')) {
            Events::attach('db:beforeQuery', function (Event $event) {
                /* @var Adapter $adapter */
                $adapter = $event->getSource();
                $binds = $adapter->getSqlVariables();
                Log::debug($adapter->getSQLStatement() . '; binds = ' . var_export($binds, 1));
            });
        }
    }

    public static function clearMetadata()
    {
        /* @var InCache $metadata */
        $metadata = static::$di->getShared('modelsMetadata');
        $metadata->reset();
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getDefaultTableCharset($name = null)
    {
        static::$instance === null and static::$instance = static::$di->getShared('dbManager');
        return self::$defaultTableCharset[$name ?: static::$instance->config['default']];
    }

    /**
     * @param string $name
     * @return Adapter|Db\Adapter\Pdo\Mysql
     */
    protected function connect($name)
    {
        $connection = $this->config['connections'][$name];
        $class = $connection['adapter'];
        isset($connection['charset']) and static::$defaultTableCharset[$name] = $connection['charset'];
        if (isset($connection['default_table_charset'])) {
            static::$defaultTableCharset[$name] = $connection['default_table_charset'];
        }
        unset($connection['adapter'], $connection['default_table_charset']);
        // @codeCoverageIgnoreStart
        if (!$class || !class_exists($class)) {
            throw new InvalidConfigException("Invalid db adapter {$class}, please check config file database.php");
        }
        // @codeCoverageIgnoreEnd
        $adapter = new $class($connection);
        // @codeCoverageIgnoreStart
        if (!$adapter instanceof Adapter) {
            throw new InvalidConfigException("Db adapter {$class} should extend " . Adapter::class);
        }
        // @codeCoverageIgnoreEnd
        return $adapter;
    }

    /**
     * @param string $name
     * @return Adapter|Db\Adapter\Pdo\Mysql
     * @throws PhalconDb\Exception
     */
    public static function connection($name = null)
    {
        static::$instance === null and static::$instance = static::$di->getShared('dbManager');
        $db = static::$instance;
        // @codeCoverageIgnoreStart
        if (!$name = $name ?: $db->config['default']) {
            throw new PhalconDb\Exception('Please set default database connection in your production config!');
        }
        // @codeCoverageIgnoreEnd

        if (!isset($db->connections[$name])) {
            $db->connections[$name] = $adapter = $db->connect($name);
            $adapter->setEventsManager(static::$di->getShared('eventsManager'));
        }

        return $db->connections[$name];
    }

    public static function reconnect($name = null)
    {
        static::$instance === null and static::$instance = static::$di->getShared('dbManager');
        $db = static::$instance;
        $db->disconnect($name = $name ?: $db->config['default']);

        if (isset($db->connections[$name])) {
            $db->connections[$name]->connect();
            return $db->connections[$name];
        }
        // @codeCoverageIgnoreStart
        return static::connection($name);
        // @codeCoverageIgnoreEnd
    }

    public function disconnect($name)
    {
        if (isset($this->connections[$name])) {
            $this->connections[$name]->close();
        }
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('modelsMetadata');
        $di->setShared('modelsMetadata', function () {
            return new InCache();
        });
        $di->setShared('dbManager', function () {
            return new static(Config::get('database'));
        });
        $di->setShared('db', function () {
            return static::connection();
        });
    }
}
