<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Session\Adapter\Redis as RedisSession;
use Phwoolcon\Config;
use Phwoolcon\Session\StartTrait;

class Redis extends RedisSession
{
    use StartTrait;

    public function __construct(array $options = [])
    {
        $options = array_merge(Config::get('cache.drivers.redis.options'), $options);
        parent::__construct($options);
    }
}
