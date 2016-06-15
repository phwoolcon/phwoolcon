<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Security;
use Phwoolcon\Tests\Helper\TestCase;

class SecurityTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testSignArrayMd5()
    {
        $data = ['foo' => 'bar'];
        $secret = 'some-stuff';
        $sign = Security::signArrayMd5($data, $secret);
        $this->assertEquals($sign, Security::signArrayMd5($data, $secret));
    }

    public function testSignArraySha256()
    {
        $data = ['foo' => 'bar'];
        $secret = 'some-stuff';
        $sign = Security::signArraySha256($data, $secret);
        $this->assertEquals($sign, Security::signArraySha256($data, $secret));
    }

    public function testSignArrayHmacSha256()
    {
        $data = ['foo' => 'bar'];
        $secret = 'some-stuff';
        $sign = Security::signArrayHmacSha256($data, $secret);
        $this->assertEquals($sign, Security::signArrayHmacSha256($data, $secret));
    }
}
