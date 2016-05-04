<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Session\Adapter;
use Phwoolcon\Config;
use Phwoolcon\Session\AdapterInterface;
use Phwoolcon\Session\AdapterTrait;
use Phwoolcon\Session\Exception;

/**
 * Class Session
 * @package Phwoolcon
 *
 * @method static bool destroy(bool $removeData = false)
 * @method static void end()
 * @method static mixed get(string $index, mixed $defaultValue = null, bool $remove = false)
 * @method static string generateCsrfToken()
 * @method static string generateRandomString()
 * @method static string getCsrfToken()
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
     * @var Adapter|AdapterTrait
     */
    static protected $session;

    public static function __callStatic($name, $arguments)
    {
        static::$session or static::$session = static::$di->getShared('session');
        return call_user_func_array([static::$session, $name], $arguments);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        ini_set('session.use_cookies', 0);
        $di->setShared('session', function () {
            $default = Config::get('session.default');
            $config = Config::get('session.drivers.' . $default);
            $class = $config['adapter'];
            $options = $config['options'];
            $options += Config::get('session.options');
            session_name($options['cookie_name']);
            strpos($class, '\\') === false and $class = 'Phwoolcon\\Session\\Adapter\\' . $class;
            $session = new $class($options);
            if (!$session instanceof AdapterInterface) {
                throw new Exception('Session class should implement ' . AdapterInterface::class);
            }
            return $session;
        });
    }
}
