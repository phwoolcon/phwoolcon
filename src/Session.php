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
 * @uses Phalcon\Session\Adapter::destroy()
 * @method static void end()
 * @uses AdapterTrait::end()
 * @method static mixed get(string $index, mixed $defaultValue = null, bool $remove = false)
 * @uses AdapterTrait::get()
 * @method static mixed getFormData(string $key, mixed $default = null)
 * @uses AdapterTrait::getFormData()
 * @method static string generateCsrfToken()
 * @uses AdapterTrait::generateCsrfToken()
 * @method static string generateRandomString()
 * @uses AdapterTrait::generateRandomString()
 * @method static string getCsrfToken(bool $renew = false)
 * @uses AdapterTrait::getCsrfToken()
 * @method static string getId()
 * @uses Phalcon\Session\Adapter::getId()
 * @method static string getName()
 * @uses Phalcon\Session\Adapter::getName()
 * @method static array getOptions()
 * @uses Phalcon\Session\Adapter::getOptions()
 * @method static bool has(string $index)
 * @uses Phalcon\Session\Adapter::has()
 * @method static bool isStarted()
 * @uses Phalcon\Session\Adapter::isStarted()
 * @method static Adapter regenerateId(bool $deleteOldSession = true)
 * @uses AdapterTrait::regenerateId()
 * @method static void remove(string $index)
 * @uses AdapterTrait::remove()
 * @method static void set(string $index, mixed $value)
 * @uses AdapterTrait::set()
 * @method static void setId(string $id)
 * @uses Phalcon\Session\Adapter::setId()
 * @method static void setName(string $id)
 * @uses Phalcon\Session\Adapter::setName()
 * @method static void setOptions(array $options)
 * @uses Phalcon\Session\Adapter::setOptions()
 * @method static bool start()
 * @uses AdapterTrait::start()
 * @method static int status()
 * @uses Phalcon\Session\Adapter::status()
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
