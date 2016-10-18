<?php
namespace Phwoolcon\Cache\Backend;

use Phalcon\Cache\Backend\Redis as PhalconRedis;
use Phalcon\Cache\Exception;
use Phalcon\Cache\FrontendInterface;

/**
 * Class Redis
 * @package Phwoolcon\Cache\Backend\Adapter
 *
 * @property FrontendInterface $_frontend
 * @property \Redis $_redis
 */
class Redis extends PhalconRedis
{

    public function decrement($keyName = null, $value = null)
    {
        // @codeCoverageIgnoreStart
        if ($keyName === null) {
            $lastKey = $this->_lastKey;
        } // @codeCoverageIgnoreEnd
        else {
            $lastKey = $this->_lastKey = $this->_prefix . $keyName;
        }
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        if (!$value) {
            return $redis->decr($lastKey);
        }
        return $redis->decrBy($lastKey, $value);
    }

    public function delete($keyName)
    {
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        $lastKey = $this->_prefix . $keyName;
        return (bool)$redis->del($lastKey);
    }

    public function exists($keyName = null, $lifetime = null)
    {
        // @codeCoverageIgnoreStart
        if ($keyName === null) {
            $lastKey = $this->_lastKey;
        } // @codeCoverageIgnoreEnd
        else {
            $lastKey = $this->_prefix . $keyName;
        }

        if ($lastKey) {
            // @codeCoverageIgnoreStart
            if (!$redis = $this->_redis) {
                $this->_connect();
                $redis = $this->_redis;
            }
            // @codeCoverageIgnoreEnd
            return $redis->exists($lastKey);
        }
        // @codeCoverageIgnoreStart
        return false;
        // @codeCoverageIgnoreEnd
    }

    public function flush()
    {
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        $redis->flushDB();
        return true;
    }

    public function get($keyName, $lifetime = null)
    {
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        $lastKey = $this->_lastKey = $this->_prefix . $keyName;
        $content = $redis->get($lastKey);
        if ($content === false) {
            return null;
        }
        return is_numeric($content) ? $content : $this->_frontend->afterRetrieve($content);
    }

    public function increment($keyName = null, $value = null)
    {
        // @codeCoverageIgnoreStart
        if ($keyName === null) {
            $lastKey = $this->_lastKey;
        } // @codeCoverageIgnoreEnd
        else {
            $lastKey = $this->_lastKey = $this->_prefix . $keyName;
        }
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        if (!$value) {
            return $redis->incr($lastKey);
        }
        return $redis->incrBy($lastKey, $value);
    }

    public function queryKeys($prefix = null)
    {
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        return $redis->keys($this->_prefix . $prefix . '*') ?: [];
    }

    public function save($keyName = null, $content = null, $lifetime = null, $stopBuffer = true)
    {
        // @codeCoverageIgnoreStart
        if ($keyName === null) {
            $lastKey = $this->_lastKey;
        } // @codeCoverageIgnoreEnd
        else {
            $lastKey = $this->_lastKey = $this->_prefix . $keyName;
        }

        // @codeCoverageIgnoreStart
        if (!$lastKey) {
            throw new Exception('The cache must be started first');
        }
        // @codeCoverageIgnoreEnd

        $frontend = $this->_frontend;
        // @codeCoverageIgnoreStart
        if (!$redis = $this->_redis) {
            $this->_connect();
            $redis = $this->_redis;
        }
        // @codeCoverageIgnoreEnd
        $cachedContent = $content === null ? $frontend->getContent() : $content;
        $preparedContent = is_numeric($cachedContent) ? $cachedContent : $frontend->beforeStore($cachedContent);
        if ($lifetime === null) {
            $ttl = $this->_lastLifetime ?: $frontend->getLifetime();
        } else {
            $ttl = $lifetime;
        }
        $success = $redis->set($lastKey, $preparedContent, $ttl);
        // @codeCoverageIgnoreStart
        if (!$success) {
            throw new Exception('Failed storing the data in redis');
        }
        // @codeCoverageIgnoreEnd
        if ($stopBuffer === true) {
            $frontend->stop();
        }
        // @codeCoverageIgnoreStart
        if ($frontend->isBuffering()) {
            echo $cachedContent;
        }
        // @codeCoverageIgnoreEnd
        $this->_started = false;
        return $success;
    }
}
