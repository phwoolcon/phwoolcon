<?php
namespace Phwoolcon\Tests\Unit;

use ErrorException;
use Exception;
use Phwoolcon\Payload;
use Phwoolcon\Tests\Helper\TestCase;

class PayloadTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testCreate()
    {
        $data = [
            'foo' => 'bar',
        ];
        $payload = Payload::create($data);
        $this->assertEquals($data, $payload->getData());
    }

    public function testSetData()
    {
        $data = [
            'foo' => 'bar',
        ];
        $payload = Payload::create([]);
        $payload->setData($data);
        $this->assertEquals($data, $payload->getData());

        $payload->setData($key = 'hello', $value = 'world');
        $this->assertEquals($value, $payload->getData($key));
    }

    public function testHasData()
    {
        $data = [
            'foo' => 'bar',
        ];
        $payload = Payload::create($data);
        $this->assertTrue($payload->hasData('foo'));
        $this->assertFalse($payload->hasData('non-exists'));
    }

    public function testMagicCallSetAndGet()
    {
        $payload = Payload::create([]);
        $this->assertNull($payload->getFoo());
        $payload->setFoo($value = 'bar');
        $this->assertEquals($value, $payload->getFoo());
    }

    public function testBadMagicCall()
    {
        $payload = Payload::create([]);
        $e = null;
        try {
            $payload->hello();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf(ErrorException::class, $e);
    }
}
