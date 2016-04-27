<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Http\Cookie;
use Phalcon\Http\Response\Cookies as PhalconCookies;

/**
 * Class Cookies
 * @package Phwoolcon
 *
 * @method static bool delete(string $name)
 * @method static Cookie get(string $name)
 * @method static PhalconCookies set(string $name, $value = null, int $expire = 0, string $path = "/", bool $secure = null, string $domain = null, bool $httpOnly = null)
 */
class Cookies
{
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var PhalconCookies
     */
    protected static $cookies;

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::$cookies, $name], $arguments);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        static::$cookies = static::$di->getShared('cookies');
        static::$cookies->useEncryption($encrypt = Config::get('cookies.encrypt'));
        $encrypt and static::$di->getShared('crypt')->setKey(Config::get('cookies.encrypt_key'));
    }
}
