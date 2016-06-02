<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Session\Adapter\Redis as RedisSession;
use Phwoolcon\Config;
use Phwoolcon\Session\AdapterInterface;
use Phwoolcon\Session\AdapterTrait;

/**
 * Class Redis
 * @package Phwoolcon\Session\Adapter
 *
 * @property \Phalcon\Cache\Backend\Redis $_redis
 * @method  \Phalcon\Cache\Backend\Redis getRedis()
 */
class Redis extends RedisSession implements AdapterInterface
{
    use AdapterTrait;

    public function __construct(array $options = [])
    {
        $options = array_merge(Config::get('cache.drivers.redis.options'), $options);
        parent::__construct($options);
    }

    public function flush()
    {
        $this->_redis->flush();
    }
}
