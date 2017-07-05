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
    protected $compressThreshold = 2048;

    public function _connect()
    {
        $options = $this->_options;
        $redis = new \Redis;
        // @codeCoverageIgnoreStart
        if (empty($options['host']) ||
            empty($options['port']) ||
            empty($options['persistent']) ||
            empty($options['index'])
        ) {
            throw new Exception('Unexpected inconsistency in options');
        }
        isset($options['compress_threshold']) and $this->compressThreshold = $options['compress_threshold'];
        // @codeCoverageIgnoreEnd
        $host = $options['host'];
        $port = $options['port'];
        $index = $options['index'];

        if ($options['persistent']) {
            $success = $redis->pconnect($host, $port, 0, $index);
        } else // @codeCoverageIgnoreStart
        {
            $success = $redis->connect($host, $port);
        }
        // @codeCoverageIgnoreEnd

        // @codeCoverageIgnoreStart
        if (!$success) {
            throw new Exception('Could not connect to the Redis server ' . $host . ':' . $port);
        }
        if (!empty($options['auth'])) {
            $success = $redis->auth($options['auth']);
            if (!$success) {
                throw new Exception('Failed to authenticate with the Redis server');
            }
        }
        // @codeCoverageIgnoreEnd

        if ($index) {
            $success = $redis->select($index);
            // @codeCoverageIgnoreStart
            if (!$success) {
                throw new Exception('Redis server selected database failed');
            }
            // @codeCoverageIgnoreEnd
        }

        $this->_redis = $redis;
    }

    protected function afterRetrieve($content)
    {
        if (is_numeric($content)) {
            return $content;
        }
        if (isset($content{1}) && $content{0} == 'g') {
            // gb: binary gzip - since 17.7.5
            if ($content{1} == 'b') {
                $content = gzinflate(substr($content, 2));
            } // @codeCoverageIgnoreStart
            // gz: base64 encoded gzip - since 16.12.2
            elseif ($content{1} == 'z') {
                $content = gzinflate(base64_decode(substr($content, 2)));
            }
            // @codeCoverageIgnoreEnd
        }
        return $this->_frontend->afterRetrieve($content);
    }

    protected function beforeStore($content)
    {
        if (is_numeric($content)) {
            return $content;
        }
        $content = $this->_frontend->beforeStore($content);
        // Compress big content
        if (strlen($content) > $this->compressThreshold) {
            // gz: base64 encoded gzip - since 16.12.2
//            $content = 'gz' . base64_encode(gzdeflate($content, 9));
            // gb: binary gzip - since 17.7.5
            $content = 'gb' . gzdeflate($content, 9);
        }
        return $content;
    }

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
        return $this->afterRetrieve($content);
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
        $preparedContent = $this->beforeStore($cachedContent);
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
