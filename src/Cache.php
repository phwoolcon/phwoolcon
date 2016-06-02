<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend;

class Cache
{
    const TTL_ONE_MINUTE = 60;
    const TTL_TEN_MINUTES = 600;
    const TTL_ONE_HOUR = 3600;
    const TTL_ONE_DAY = 86400;
    const TTL_ONE_WEEK = 604800;
    const TTL_ONE_MONTH = 2592000;

    /**
     * @var Backend|Backend\File|Backend\Redis
     */
    protected static $cache;

    public static function delete($key)
    {
        static::$cache === null and static::$cache = Di::getDefault()->getShared('cache');
        return static::$cache->delete($key);
    }

    public static function flush()
    {
        static::$cache === null and static::$cache = Di::getDefault()->getShared('cache');
        return static::$cache->flush();
    }

    public static function get($key, $default = null)
    {
        static::$cache === null and static::$cache = Di::getDefault()->getShared('cache');
        return (null === $value = static::$cache->get($key)) ? $default : $value;
    }

    public static function register(Di $di)
    {
        $di->remove('cache');
        static::$cache = null;
        $di->setShared('cache', function () {
            $frontend = new Data(['lifetime' => static::TTL_ONE_DAY]);
            $default = Config::get('cache.default');
            $config = Config::get('cache.drivers.' . $default);
            $class = $config['adapter'];
            $options = $config['options'];
            strpos($class, '\\') === false and $class = 'Phalcon\\Cache\\Backend\\' . $class;
            isset($options['cacheDir']) and $options['cacheDir'] = storagePath($options['cacheDir']) . '/';
            /* @var Backend $backend */
            $backend = new $class($frontend, $options);
            return $backend;
        });
    }

    public static function set($key, $value, $ttl = null)
    {
        static::$cache === null and static::$cache = Di::getDefault()->getShared('cache');
        static::$cache->save($key, $value, $ttl);
    }
}
