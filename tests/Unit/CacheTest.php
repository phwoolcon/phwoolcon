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
        $value = 'Some stub';
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
        $keys = Cache::queryKeys($cacheKey);
        $this->assertNotEmpty($keys);
    }
}
