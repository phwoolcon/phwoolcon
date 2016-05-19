<?php

namespace Phwoolcon;

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
        Model::setup([
            'distributed' => $config['distributed'],
        ]);
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
        isset($connection['default_table_charset']) and static::$defaultTableCharset[$name] = $connection['default_table_charset'];
        unset($connection['adapter'], $connection['default_table_charset']);
        strpos($class, '\\') === false and $class = 'Phalcon\\Db\\Adapter\\Pdo\\' . $class;
        return new $class($connection);
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
        if (!$name = $name ?: $db->config['default']) {
            throw new PhalconDb\Exception('Please set default database connection in your production config!');
        }

        if (!isset($db->connections[$name])) {
            $db->connections[$name] = $db->connect($name);
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
        return static::connection($name);
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
