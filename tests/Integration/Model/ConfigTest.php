<?php
namespace Phwoolcon\Tests\Integration\Model;

use Phwoolcon\Config;
use Phwoolcon\Model\Config as ConfigModel;
use Phwoolcon\Tests\Helper\TestCase;

class ConfigTest extends TestCase
{

    public function testSaveConfig()
    {
        // Test save array value
        $key = 'test_save';
        $subKey = $key . '.foo';
        $value = ['foo' => $subValue = 'bar'];
        ConfigModel::saveConfig($key, $value);
        Config::register($this->di);
        $this->assertEquals($value, Config::get($key));

        // Test save null value
        ConfigModel::saveConfig($key, null);
        $this->assertFalse(ConfigModel::findFirstSimple(['key' => $key]));

        // Test save a non-existing sub key
        ConfigModel::saveConfig($subKey, $subValue);
        Config::register($this->di);
        $this->assertEquals($subValue, Config::get($subKey));

        // Test save a existing sub key
        $subValue = 'baz';
        ConfigModel::saveConfig($subKey, $subValue);
        Config::register($this->di);
        $this->assertEquals($subValue, Config::get($subKey));
    }
}
