<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend;
use Phwoolcon\Cache\Backend\Redis;
use Phwoolcon\Exception\InvalidConfigException;

/**
 * Class Cache
 * @package Phwoolcon
 *
 * @method static int decrement(string $keyName = null, int $value = null)
 * @uses Redis::decrement()
 * @method static bool exists(string $keyName = null)
 * @uses Redis::exists()
 * @method static int increment(string $keyName = null, int $value = null)
 * @uses Redis::increment()
 * @method static array queryKeys(string $prefix = null)
 * @uses Redis::queryKeys()
 */
class Cache
{
    const TTL_ONE_MINUTE = 60;
    const TTL_TEN_MINUTES = 600;
    const TTL_ONE_HOUR = 3600;
    const TTL_ONE_DAY = 86400;
    const TTL_ONE_WEEK = 604800;
    const TTL_ONE_MONTH = 2592000;

    /**
     * @var Backend|Backend\File|Redis
     */
    protected static $cache;
    /**
     * @var Di
     */
    protected static $di;

    public static function __callStatic($name, $arguments)
    {
        static::$cache === null and static::$cache = static::$di->getShared('cache');
        return call_user_func_array([static::$cache, $name], $arguments);
    }

    public static function delete($key)
    {
        static::$cache === null and static::$cache = static::$di->getShared('cache');
        return static::$cache->delete($key);
    }

    public static function flush()
    {
        static::$cache === null and static::$cache = static::$di->getShared('cache');
        return static::$cache->flush();
    }

    public static function get($key, $default = null)
    {
        static::$cache === null and static::$cache = static::$di->getShared('cache');
        return (null === $value = static::$cache->get($key)) ? $default : $value;
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('cache');
        static::$cache = null;
        $di->setShared('cache', function () {
            $frontend = new Data(['lifetime' => static::TTL_ONE_DAY]);
            $default = Config::get('cache.default');
            $config = Config::get('cache.drivers.' . $default);
            $class = $config['adapter'];
            $options = $config['options'];
            // @codeCoverageIgnoreStart
            if (!$class || !class_exists($class)) {
                throw new InvalidConfigException("Invalid cache adapter {$class}, please check config file cache.php");
            }
            // @codeCoverageIgnoreEnd
            isset($options['cacheDir']) and $options['cacheDir'] = storagePath($options['cacheDir']) . '/';
            /* @var Backend $backend */
            $backend = new $class($frontend, $options);
            // @codeCoverageIgnoreStart
            if (!$backend instanceof Backend) {
                throw new InvalidConfigException("Cache adapter {$class} should extend " . Backend::class);
            }
            // @codeCoverageIgnoreEnd
            return $backend;
        });
    }

    public static function set($key, $value, $ttl = null)
    {
        static::$cache === null and static::$cache = static::$di->getShared('cache');
        static::$cache->save($key, $value, $ttl);
    }
}
