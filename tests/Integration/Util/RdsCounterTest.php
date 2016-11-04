<?php
namespace Phwoolcon\Tests\Integration\Util;

use Phwoolcon\Config;
use Phwoolcon\Db;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Util\Counter;

class RdsCounterTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Config::set('counter.default', 'rds');
        Counter::register($this->di);
        $db = Db::connection();
        $db->tableExists('counter') and $db->dropTable('counter');
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
