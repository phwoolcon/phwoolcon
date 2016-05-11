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
     * @var Adapter|Db\Adapter\Pdo\Mysql
     */
    protected static $instance;
    protected static $defaultTableCharset;

    public static function clearMetadata()
    {
        /* @var InCache $metadata */
        $metadata = static::$di->getShared('modelsMetadata');
        $metadata->reset();
    }

    /**
     * @return string
     */
    public static function getDefaultTableCharset()
    {
        return self::$defaultTableCharset;
    }

    /**
     * @return Adapter|Db\Adapter\Pdo\Mysql
     */
    public static function getInstance()
    {
        static::$instance === null and static::setInstance(static::$di->getShared('db'));
        return static::$instance;
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('modelsMetadata');
        $di->setShared('modelsMetadata', function () {
            return new InCache();
        });
        $di->setShared('db', function () {
            $config = Config::get('database');
            $connection = $config['connections'][$config['default']];
            $class = $connection['adapter'];
            isset($connection['charset']) and static::$defaultTableCharset = $connection['charset'];
            isset($connection['default_table_charset']) and static::$defaultTableCharset = $connection['default_table_charset'];
            unset($connection['adapter'], $connection['default_table_charset']);
            strpos($class, '\\') === false and $class = 'Phalcon\\Db\\Adapter\\Pdo\\' . $class;
            Model::setup([
                'distributed' => $config['distributed'],
            ]);
            return new $class($connection);
        });
    }

    /**
     * @param string $defaultTableCharset
     */
    public static function setDefaultTableCharset($defaultTableCharset)
    {
        self::$defaultTableCharset = $defaultTableCharset;
    }

    public static function setInstance(Adapter $instance)
    {
        static::$instance = $instance;
    }
}
