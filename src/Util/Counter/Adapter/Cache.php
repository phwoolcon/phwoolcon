<?php
namespace Phwoolcon\Util\Counter\Adapter;

use Phalcon\Cache\Backend;
use Phalcon\Di;
use Phwoolcon\Cache\Backend\Redis;
use Phwoolcon\Util\Counter\Adapter;

class Cache extends Adapter
{
    /**
     * @var Backend|Redis
     */
    protected $cache;
    protected $prefix = 'counter:';

    public function __construct($options)
    {
        parent::__construct($options);
        $this->cache = Di::getDefault()->getShared('cache');
        $this->cache instanceof Backend\File and $this->prefix = 'counter-';
    }

    public function increment($keyName, $value = 1)
    {
        return $this->cache->increment($this->prefix . $keyName, $value);
    }

    public function decrement($keyName, $value = 1)
    {
        return $this->cache->decrement($this->prefix . $keyName, $value);
    }

    public function reset($keyName)
    {
        $this->cache->save($this->prefix . $keyName, 0);
    }
}
