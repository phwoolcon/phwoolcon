<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Session\Adapter;
use Phwoolcon\Config;

/**
 * Class Session
 * @package Phwoolcon
 *
 * @method static bool destroy(bool $removeData = false)
 * @method static mixed get(string $index, mixed $defaultValue = null, bool $remove = false)
 * @method static string getId()
 * @method static string getName()
 * @method static array getOptions()
 * @method static bool has(string $index)
 * @method static bool isStarted()
 * @method static Adapter regenerateId(bool $deleteOldSession = true)
 * @method static void remove(string $index)
 * @method static void set(string $index, mixed $value)
 * @method static void setId(string $id)
 * @method static void setName(string $id)
 * @method static void setOptions(array $options)
 * @method static bool start()
 * @method static int status()
 */
class Session
{
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var Adapter
     */
    static protected $session;

    public static function __callStatic($name, $arguments)
    {
        static::$session or static::$session = static::$di->getShared('session');
        static::$session->start();
        return call_user_func_array([static::$session, $name], $arguments);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->setShared('session', function () {
            $default = Config::get('session.default');
            $config = Config::get('session.drivers.' . $default);
            $class = $config['adapter'];
            $options = $config['options'];
            strpos($class, '\\') === false and $class = 'Phwoolcon\\Session\\Adapter\\' . $class;
            return new $class($options);
        });
    }
}
