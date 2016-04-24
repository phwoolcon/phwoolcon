<?php

namespace Phwoolcon\Model\MetaData;

use Phwoolcon\Cache;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\Model\Exception;

/**
 * Phwoolcon\Model\MetaData\InCache
 *
 * Stores model meta-data in cache.
 *
 *<code>
 * $metaData = new \Phwoolcon\Model\Metadata\InCache();
 *</code>
 */
class InCache extends MetaData
{
    protected $_metaData = [];

    protected function prepareVirtualPath($key, $separator = '_')
    {
        return strtr($key, ['/' => $separator, '\\' => $separator, ':' => $separator]);
    }

    /**
     * Reads meta-data from files
     *
     * @param string $key
     * @return mixed
     */
    public function read($key)
    {
        return Cache::get($this->prepareVirtualPath($key));
    }

    /**
     * Writes the meta-data to files
     *
     * @param string $key
     * @param array  $data
     */
    public function write($key, $data)
    {
        Cache::set($this->prepareVirtualPath($key), $data, Cache::TTL_ONE_MONTH);
    }
}
