<?php
namespace Phwoolcon\Tests\Integration\Util;

use Phwoolcon\Config;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Util\Counter;

class AutoCounterTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Config::set('counter.default', 'auto');
        Counter::register($this->di);
    }

    public function tearDown()
    {
        Config::set('counter.default', 'auto');
        parent::tearDown();
    }

    public function testIncrement()
    {
        $key1 = 'test';
        $key2 = 'test2';
        Counter::reset($key1);
        Counter::reset($key2);
        $this->assertEquals(1, Counter::increment($key1));
        $this->assertEquals(2, Counter::increment($key1));
        $this->assertEquals(1, Counter::increment($key2));
        $this->assertEquals(2, Counter::increment($key2));
        $this->assertEquals(4, Counter::increment($key2, 2));
        $this->assertEquals(4, Counter::increment($key1, 2));
    }

    public function testDecrement()
    {
        $key1 = 'test';
        $key2 = 'test2';
        Counter::reset($key1);
        Counter::reset($key2);
        $this->assertEquals(10, Counter::increment($key1, 10));
        $this->assertEquals(10, Counter::increment($key2, 10));
        $this->assertEquals(9, Counter::decrement($key1));
        $this->assertEquals(8, Counter::decrement($key1));
        $this->assertEquals(9, Counter::decrement($key2));
        $this->assertEquals(8, Counter::decrement($key2));
        $this->assertEquals(6, Counter::decrement($key2, 2));
        $this->assertEquals(6, Counter::decrement($key1, 2));
        $this->assertEquals(-2, Counter::decrement($key2, 8));
        $this->assertEquals(-2, Counter::decrement($key1, 8));
    }
}
