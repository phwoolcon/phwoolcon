<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Events\Manager;

/**
 * Class Events
 * @package Phwoolcon
 *
 * @method static void detach(string $eventType, object $handler)
 * @see Manager::detach()
 * @method static void detachAll(string $type = null)
 * @see Manager::detachAll()
 */
class Events
{
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var Manager
     */
    protected static $event;

    public static function __callStatic($name, $arguments)
    {
        static::$event or static::$event = static::$di->getShared('eventsManager');
        return call_user_func_array([static::$event, $name], $arguments);
    }

    public static function attach($eventType, $handler, $priority = 100)
    {
        static::$event or static::$event = static::$di->getShared('eventsManager');
        static::$event->attach($eventType, $handler, $priority);
    }

    public static function fire($eventType, $source, $data = null, $cancelable = true)
    {
        static::$event or static::$event = static::$di->getShared('eventsManager');
        return static::$event->fire($eventType, $source, $data, $cancelable);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
    }
}
