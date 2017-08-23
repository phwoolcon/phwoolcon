<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Session\Adapter;
use Phwoolcon\Exception\InvalidConfigException;
use Phwoolcon\Session\AdapterInterface;
use Phwoolcon\Session\AdapterTrait;

/**
 * Class Session
 * @package Phwoolcon
 *
 * @method static void clear()
 * @uses AdapterTrait::clear()
 * @method static void clearFormData(string $key)
 * @uses AdapterTrait::clearFormData()
 * @method static bool destroy(bool $removeData = false)
 * @uses \Phalcon\Session\Adapter::destroy()
 * @method static void end()
 * @uses AdapterTrait::end()
 * @method static void flush()
 * @uses AdapterTrait::flush()
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
 * @uses \Phalcon\Session\Adapter::getId()
 * @method static string getName()
 * @uses \Phalcon\Session\Adapter::getName()
 * @method static array getOptions()
 * @uses \Phalcon\Session\Adapter::getOptions()
 * @method static bool has(string $index)
 * @uses \Phalcon\Session\Adapter::has()
 * @method static bool isStarted()
 * @uses \Phalcon\Session\Adapter::isStarted()
 * @method static AdapterTrait regenerateId(bool $deleteOldSession = true)
 * @uses AdapterTrait::regenerateId()
 * @method static void rememberFormData(string $key, $data)
 * @uses AdapterTrait::rememberFormData()
 * @method static void remove(string $index)
 * @uses AdapterTrait::remove()
 * @method static void set(string $index, mixed $value)
 * @uses AdapterTrait::set()
 * @method static AdapterTrait setCookie()
 * @uses AdapterTrait::setCookie()
 * @method static void setId(string $id)
 * @uses \Phalcon\Session\Adapter::setId()
 * @method static void setName(string $id)
 * @uses \Phalcon\Session\Adapter::setName()
 * @method static void setOptions(array $options)
 * @uses \Phalcon\Session\Adapter::setOptions()
 * @method static bool start()
 * @uses AdapterTrait::start()
 * @method static int status()
 * @uses \Phalcon\Session\Adapter::status()
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
        $di->remove('session');
        static::$session = null;
        $di->setShared('session', function () {
            $default = Config::get('session.default');
            $config = Config::get('session.drivers.' . $default);
            $class = $config['adapter'];
            $options = $config['options'];
            $options += Config::get('session.options');
            $options['cookies'] += Config::get('cookies');
            session_name($options['cookies']['name']);
            // @codeCoverageIgnoreStart
            if (!$class || !class_exists($class)) {
                $errorMessage = "Invalid session adapter {$class}, please check config file session.php";
                throw new InvalidConfigException($errorMessage);
            }
            // @codeCoverageIgnoreEnd
            $session = new $class($options);
            // @codeCoverageIgnoreStart
            if (!$session instanceof AdapterInterface) {
                $errorMessage = "Session adapter {$class} should implement " . AdapterInterface::class;
                throw new InvalidConfigException($errorMessage);
            }
            // @codeCoverageIgnoreEnd
            return $session;
        });
    }
}
