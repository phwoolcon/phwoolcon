<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Http\Cookie;
use Phalcon\Http\Response\Cookies as PhalconCookies;

/**
 * Class Cookies
 * @package Phwoolcon
 *
 * @method static bool delete(string $name)
 * @method static Cookie get(string $name)
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
    protected static $options;

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::$cookies, $name], $arguments);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        static::$cookies = static::$di->getShared('cookies');
        static::$options = $options = Config::get('cookies');
        static::$cookies->useEncryption($encrypt = $options['encrypt']);
        $encrypt and static::$di->getShared('crypt')
            ->setKey($options['encrypt_key'])
            ->setPadding(Crypt::PADDING_ZERO);
        Events::attach('view:generatePhwoolconJsOptions', function (Event $event) {
            $options = $event->getData() ?: [];
            $options['cookies'] = [
                'domain' => static::$options['domain'],
                'path' => static::$options['path'],
            ];
            $event->setData($options);
            return $options;
        });
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @param int    $expire
     * @param string $path
     * @param bool   $secure
     * @param string $domain
     * @param bool   $httpOnly
     * @return PhalconCookies
     */
    public static function set($name, $value = null, $expire = 0, $path = null, $secure = null, $domain = null, $httpOnly = null)
    {
        $options = static::$options;
        $path === null and $path = $options['path'];
        $domain === null and $domain = $options['domain'];
        return static::$cookies->set($name, $value, $expire, $path, $secure, $domain, $httpOnly);
    }
}
