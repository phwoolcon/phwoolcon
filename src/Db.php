<?php

namespace Phwoolcon;

use Phwoolcon\Model\MetaData\InCache;
use Phalcon\Di;
use Phalcon\Db as PhalconDb;
use Phalcon\Db\Adapter\Pdo as Adapter;

class Db extends PhalconDb
{
    /**
     * @var Adapter|Adapter\Mysql
     */
    protected static $instance;

    /**
     * @return Adapter|Adapter\Mysql
     */
    public static function getInstance()
    {
        static::$instance === null and static::setInstance(Di::getDefault()->getShared('db'));
        return static::$instance;
    }

    public static function register(Di $di)
    {
        $di->remove('modelsMetadata');
        $di->setShared('modelsMetadata', function () {
            return new InCache();
        });
        $di->setShared('db', function () {
            $default = Config::get('database.default');
            $config = Config::get('database.connections.' . $default);
            $class = $config['adapter'];
            unset($config['adapter']);
            strpos($class, '\\') === false and $class = 'Phalcon\\Db\\Adapter\\Pdo\\' . $class;
            return new $class($config);
        });
    }

    public static function setInstance(Adapter $instance)
    {
        static::$instance = $instance;
    }
}
