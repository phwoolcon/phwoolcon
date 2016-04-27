<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Session\Adapter\Redis as RedisSession;
use Phwoolcon\Config;
use Phwoolcon\Session\AdapterInterface;
use Phwoolcon\Session\AdapterTrait;

class Redis extends RedisSession implements AdapterInterface
{
    use AdapterTrait;

    public function __construct(array $options = [])
    {
        $options = array_merge(Config::get('cache.drivers.redis.options'), $options);
        parent::__construct($options);
    }
}
