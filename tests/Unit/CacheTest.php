<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cache;
use Phwoolcon\Tests\Helper\TestCase;

class CacheTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Cache::register($this->di);
        Cache::flush();
    }

    public function testSetAndRemoveCache()
    {
        $cacheKey = 'test.set.cache';
        $value = str_repeat('Some stub', 1000);
        Cache::set($cacheKey, $value);
        $this->assertEquals($value, Cache::get($cacheKey), 'Unable to set cache');
        Cache::delete($cacheKey);
        $this->assertNull(Cache::get($cacheKey), 'Unable to delete cache');

        $cacheKey = 'test.set.cache';
        $value = 1234;
        Cache::set($cacheKey, $value);
        $this->assertEquals($value, Cache::get($cacheKey), 'Unable to set cache');
        Cache::delete($cacheKey);
        $this->assertNull(Cache::get($cacheKey), 'Unable to delete cache');
    }

    public function testCounter()
    {
        $cacheKey = 'test.counter';
        Cache::set($cacheKey, 0);
        $count = Cache::increment($cacheKey);
        $this->assertEquals(1, $count);
        $count = Cache::increment($cacheKey, 2);
        $this->assertEquals(3, $count);
        $count = Cache::decrement($cacheKey);
        $this->assertEquals(2, $count);
        $count = Cache::decrement($cacheKey, 2);
        $this->assertEquals(0, $count);
    }

    public function testExistsAndKeys()
    {
        $cacheKey = 'test.exists';
        $exists = Cache::exists($cacheKey);
        $this->assertFalse($exists);
        Cache::set($cacheKey, 'foo');
        $exists = Cache::exists($cacheKey);
        $this->assertTrue($exists);
        // Bug in version < 3.0.2: query keys with prefix in file cache
        if ($_SERVER['PHWOOLCON_PHALCON_VERSION'] >= 3000200) {
            $keys = Cache::queryKeys($cacheKey);
        } else {
            $keys = Cache::queryKeys();
        }
        $this->assertNotEmpty($keys);
    }
}
