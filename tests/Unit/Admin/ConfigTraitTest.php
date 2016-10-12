<?php
namespace Phwoolcon\Tests\Unit\Admin;

use Exception;
use Phalcon\Validation\Exception as ValidationException;
use Phwoolcon\Config;
use Phwoolcon\Tests\Helper\Admin\TestConfigTrait;
use Phwoolcon\Tests\Helper\TestCase;

class ConfigTraitTest extends TestCase
{
    /**
     * @var TestConfigTrait
     */
    protected $configTrait;

    public function setUp()
    {
        parent::setUp();
        $this->configTrait = new TestConfigTrait();
        Config::set('white_listed', [
            '_white_list' => [
                'foo',
            ],
            'foo' => 'bar',
            'hello' => 'world',
        ]);
        Config::set('black_listed', [
            '_black_list' => [
                'foo',
            ],
            'foo' => 'bar',
            'hello' => 'world',
        ]);
        Config::set('protected', [
            'foo' => 'bar',
            'hello' => 'world',
        ]);
    }

    public function testKeyList()
    {
        $list = $this->configTrait->keyList();

        $this->assertArrayHasKey($whiteListed = 'white_listed', $list);
        $this->assertArrayHasKey($blackListed = 'black_listed', $list);
        $this->assertArrayNotHasKey($protected = 'protected', $list);

        $this->assertNotEmpty(Config::get($whiteListed));
        $this->assertNotEmpty(Config::get($blackListed));
        $this->assertNotEmpty(Config::get($protected));
    }

    public function testGetCurrentConfig()
    {
        $key = 'white_listed';
        $currentConfig = $this->configTrait->getCurrentConfig($key);
        // foo should be visible because it is in white list
        $this->assertEquals(fnGet($currentConfig, 'foo'), Config::get($key . '.foo'));
        // hello should be invisible because it is not in white list
        $this->assertNotEquals(fnGet($currentConfig, 'hello'), Config::get($key . '.hello'));

        $key = 'black_listed';
        $currentConfig = $this->configTrait->getCurrentConfig($key);
        // foo should be invisible because it is in black list
        $this->assertNotEquals(fnGet($currentConfig, 'foo'), Config::get($key . '.foo'));
        // hello should be visible because it is not in black list
        $this->assertEquals(fnGet($currentConfig, 'hello'), Config::get($key . '.hello'));

        $e = false;
        $key = 'protected';
        try {
            $this->configTrait->getCurrentConfig($key);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf(ValidationException::class, $e);
    }

    public function testFilterConfig()
    {
        $data = [
            'foo' => 'baz',
            'hello' => 'word',
        ];
        $key = 'white_listed';
        $filteredData = $this->configTrait->filterConfig($key, $data);
        // foo should be kept because it is in white list
        $this->assertEquals(fnGet($filteredData, 'foo'), fnGet($data, 'foo'));
        // hello should be removed because it is not in white list
        $this->assertNotEquals(fnGet($filteredData, 'hello'), fnGet($data, 'hello'));

        $key = 'black_listed';
        $filteredData = $this->configTrait->filterConfig($key, $data);
        // foo should be removed because it is in black list
        $this->assertNotEquals(fnGet($filteredData, 'foo'), fnGet($data, 'foo'));
        // hello should be kept because it is not in black list
        $this->assertEquals(fnGet($filteredData, 'hello'), fnGet($data, 'hello'));

        $e = false;
        $key = 'protected';
        try {
            $this->configTrait->filterConfig($key, $data);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf(ValidationException::class, $e);
    }

    public function testSubmitConfig()
    {
        $data = [
            'foo' => 'baz',
            'hello' => 'word',
        ];
        $rawData = json_encode($data);
        $key = 'white_listed';
        $submittedData = $this->configTrait->submitConfig($key, $rawData);
        // foo should be kept because it is in white list
        $this->assertEquals(fnGet($submittedData, 'foo'), fnGet($data, 'foo'));
        // hello should be removed because it is not in white list
        $this->assertNotEquals(fnGet($submittedData, 'hello'), fnGet($data, 'hello'));

        $key = 'black_listed';
        $submittedData = $this->configTrait->submitConfig($key, $rawData);
        // foo should be removed because it is in black list
        $this->assertNotEquals(fnGet($submittedData, 'foo'), fnGet($data, 'foo'));
        // hello should be kept because it is not in black list
        $this->assertEquals(fnGet($submittedData, 'hello'), fnGet($data, 'hello'));

        $e = false;
        $key = 'protected';
        try {
            $this->configTrait->submitConfig($key, $rawData);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf(ValidationException::class, $e);

        $e = false;
        $key = 'white_listed';
        $badData = $rawData . 'oops';
        try {
            $this->configTrait->submitConfig($key, $badData);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf(ValidationException::class, $e);
    }
}
