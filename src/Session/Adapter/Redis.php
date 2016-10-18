<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Cache\Frontend\None as FrontendNone;
use Phalcon\Session\Adapter\Redis as RedisSession;
use Phwoolcon\Cache\Backend\Redis as RedisCache;
use Phwoolcon\Config;
use Phwoolcon\Session\AdapterInterface;
use Phwoolcon\Session\AdapterTrait;

/**
 * Class Redis
 * @package Phwoolcon\Session\Adapter
 *
 * @property RedisCache $_redis
 * @method  RedisCache getRedis()
 */
class Redis extends RedisSession implements AdapterInterface
{
    use AdapterTrait;

    public function __construct(array $options = [])
    {
        $options = array_merge(Config::get('cache.drivers.redis.options'), $options);
        parent::__construct($options);
        $this->_redis = new RedisCache(new FrontendNone, $options);
    }

    public function flush()
    {
        $this->_redis->flush();
    }
}
