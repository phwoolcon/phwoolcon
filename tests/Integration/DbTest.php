<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Config;
use Phwoolcon\Db;
use Phwoolcon\Tests\TestCase;

class DbTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Db::connection()->dropTable('config');
        Config::register($this->di);
    }

    public function testGetDefaultTableCharset()
    {
        $this->assertEquals('utf8_unicode_ci', Db::getDefaultTableCharset());
    }

    public function testConnection()
    {
        $this->assertEquals('value', Db::connection()->query('SELECT "value" v')->fetch()['v'], 'Unable to connect DB');
    }

    public function testReconnect()
    {
        $this->assertEquals('value', Db::reconnect()->query('SELECT "value" v')->fetch()['v'], 'Unable to reconnect DB');
    }
}
