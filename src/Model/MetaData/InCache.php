<?php

namespace Phwoolcon\Model\MetaData;

use Phwoolcon\Cache;
use Phalcon\Mvc\ModelInterface;
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
    protected $_cachedData = [];

    public function getNonPrimaryKeyAttributes(ModelInterface $model)
    {
        return $this->getAttributes($model);
    }

    /**
     * Reads meta-data from files
     *
     * @param string $key
     * @return mixed
     */
    public function read($key)
    {
        $this->_cachedData or $this->_cachedData = Cache::get('model-metadata');
        return isset($this->_cachedData[$key]) ? $this->_cachedData[$key] : null;
    }

    /**
     * Writes the meta-data to files
     *
     * @param string $key
     * @param array  $data
     */
    public function write($key, $data)
    {
        $this->_cachedData[$key] = $data;
        Cache::set('model-metadata', $this->_cachedData, Cache::TTL_ONE_MONTH);
    }

    public function reset()
    {
        parent::reset();
        $this->_cachedData = [];
        Cache::delete('model-metadata');
    }
}
