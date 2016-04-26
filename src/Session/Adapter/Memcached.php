<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Session\Adapter\Libmemcached;
use Phwoolcon\Config;
use Phwoolcon\Session\StartTrait;

class Memcached extends Libmemcached
{
    use StartTrait;

    public function __construct(array $options = [])
    {
        $options = array_merge(Config::get('cache.drivers.memcached.options'), $options);
        parent::__construct($options);
    }
}
