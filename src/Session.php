<?php
namespace Phwoolcon;

use Phwoolcon\Config;
use Phalcon\DiInterface;

class Session
{

    static protected $session;

    public static function register(DiInterface $di)
    {
        $sessionConfigs = Config::get('session');
        if (fnGet($sessionConfigs, 'enable') === true) {
            $default = fnGet($sessionConfigs, 'default') ?: 'files';
            $default = in_array($default, array_keys(fnGet($sessionConfigs, 'drivers'))) ? $default : 'files';
            $defaultConfig = fnGet($sessionConfigs, 'drivers/' . $default);

            $di->setShared('session', function () use ($default, $defaultConfig) {
                $class = "\\Phalcon\\Session\\Adapter\\" . (is_null($adapter = fnGet($defaultConfig, 'adapter')) ?
                        ucfirst(strtolower($default)) : $adapter);
                unset($defaultConfig['adapter']);
                $session = new $class($defaultConfig);
                $session->start();
                return $session;
            });
            static::$session = $di->getShared('session');
        }
    }

    public static function __callStatic($name, $arguments)
    {
        $session = static::$session;
        if (method_exists($session, $name)) {
            return call_user_func_array([$session, $name], $arguments);
        }
        throw new \Exception('method not found!');
    }

}
