<?php
namespace Phwoolcon\Util\Counter\Adapter;

use Phwoolcon\Config;
use Phwoolcon\Util\Counter\Adapter;
use Phwoolcon\Util\Counter\AdapterInterface;

class Auto extends Adapter
{
    /**
     * @var AdapterInterface
     */
    protected $realCounter;
    protected $realOptions = [];

    public function __construct($options)
    {
        parent::__construct($options);
        $cacheType = Config::get('cache.default');
        if ($cacheType == 'redis' || $cacheType == 'memcached') {
            $realAdapter = Cache::class;
            $this->realOptions = Config::get('counter.drivers.cache.options');
        } // @codeCoverageIgnoreStart
        else {
            $realAdapter = Rds::class;
            $this->realOptions = Config::get('counter.drivers.rds.options');
        }
        // @codeCoverageIgnoreEnd
        $this->realCounter = new $realAdapter($this->realOptions);
    }

    public function increment($keyName, $value = 1)
    {
        return $this->realCounter->increment($keyName, $value);
    }

    public function decrement($keyName, $value = 1)
    {
        return $this->realCounter->decrement($keyName, $value);
    }

    public function reset($keyName)
    {
        return $this->realCounter->reset($keyName);
    }
}
