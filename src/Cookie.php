<?php
namespace Phwoolcon;

use Phalcon\DiInterface;
use Phalcon\Http\Response\Cookies;
use Phalcon\Crypt;
use Phwoolcon\Log;

class Cookie
{
    protected static $cookie;

    public static function register(DiInterface $di)
    {
        $cookieConfig = Config::get('cookie');
        $di->set('cookies', function () use ($cookieConfig) {
            $cookies = new Cookies();
            //是否加密 cookie
            $cookies->useEncryption(fnGet($cookieConfig, 'encrypt') ? true : false);
            return $cookies;
        });
        static::$cookie = $di->getShared('cookies');

        //是否加密 cookie
        if (fnGet($cookieConfig, 'encrypt')) {
            $di->set('crypt', function () use ($cookieConfig) {
                $crypt = new Crypt();
                $crypt->setKey(fnGet($cookieConfig, 'option/encrypt_key'));
                return $crypt;
            });
        }
    }

    public static function __callStatic($name, $arguments)
    {
        $cookie = static::$cookie;
        if (method_exists($cookie, $name)) {
            return call_user_func_array([$cookie, $name], $arguments);
        }
        throw new \Exception('cookie function method not found!');
    }
}
