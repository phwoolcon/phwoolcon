<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cache;
use Phwoolcon\Tests\TestCase;

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
}
