<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cookies;
use Phwoolcon\Crypt;
use Phwoolcon\Http\Cookie;
use Phwoolcon\Tests\Helper\TestCase;

class CookiesTest extends TestCase
{

    public function testSetAndGet()
    {
        Cookies::reset();
        Cookies::set($name = 'foo', $value = 'bar');
        $this->assertEquals($value, Cookies::get($name));
        Cookies::reset();
    }

    public function testToArray()
    {
        Cookies::reset();
        Cookies::set($name = 'hello', $value = 'world');
        foreach (Cookies::toArray() as $cookie) {
            $this->assertInstanceOf(Cookie::class, $cookie);
            $this->assertEquals($name, $cookie->getName());
            $this->assertEquals($value, $cookie->getValue());
            break;
        }
        Cookies::reset();
    }

    public function testGetResponseValue()
    {
        Cookies::reset();
        Cookies::set($name = 'hello', $value = 'world');
        $cookie = Cookies::get($name);
        $cookie->useEncryption(false);
        $this->assertEquals($name, $cookie->getName());
        $this->assertEquals($value, $cookie->getResponseValue());

        $cookie->useEncryption(true);
        $this->assertNotEquals($value, $encrypted = $cookie->getResponseValue());

        /* @var \Phalcon\Crypt $crypt */
        $crypt = $this->di->getShared('crypt');
        $this->assertEquals($value, $crypt->decryptBase64($encrypted));
        Cookies::reset();
    }
}
