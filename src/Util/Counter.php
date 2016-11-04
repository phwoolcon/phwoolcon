<?php
namespace Phwoolcon\Util;

use Phalcon\Di;
use Phwoolcon\Config;
use Phwoolcon\Util\Counter\AdapterInterface;

class Counter
{
    /**
     * @var AdapterInterface
     */
    protected static $adapter;
    /**
     * @var Di
     */
    protected static $di;

    public static function increment($keyName, $value = 1)
    {
        static::$adapter === null and static::$adapter = static::$di->getShared('counter');
        return static::$adapter->increment($keyName, ((int)$value) ?: 1);
    }

    public static function decrement($keyName, $value = 1)
    {
        static::$adapter === null and static::$adapter = static::$di->getShared('counter');
        return static::$adapter->decrement($keyName, ((int)$value) ?: 1);
    }

    public static function reset($keyName)
    {
        static::$adapter === null and static::$adapter = static::$di->getShared('counter');
        return static::$adapter->reset($keyName);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('counter');
        static::$adapter = null;
        $di->setShared('counter', function () {
            $default = Config::get('counter.default');
            $config = Config::get('counter.drivers.' . $default);
            $class = $config['adapter'];
            $options = $config['options'];
            strpos($class, '\\') === false and $class = 'Phwoolcon\\Util\\Counter\\' . $class;
            return new $class($options);
        });
    }
}
