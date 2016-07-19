<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Config;
use Phwoolcon\Tests\Helper\TestCase;

class FunctionsTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testArrayForget()
    {
        $array = [
            'child' => [
                'child' => [
                    'child' => 'no child',
                ],
            ],
        ];
        $this->assertTrue(isset($array['child']['child']['child']), 'Bad initial array');
        array_forget($array, 'child.child.child');
        $this->assertTrue(!isset($array['child']['child']['child']), 'Unable to forget array key');
        $this->assertTrue(isset($array['child']['child']), 'Bad forget array result');
        array_forget($array, 'child.child.child.child');
    }

    public function testArraySet()
    {
        $array = [];
        $value = 'no child';
        $this->assertTrue(!isset($array['child']), 'Bad initial array');
        array_set($array, 'child.child.child', $value);
        $this->assertTrue(isset($array['child']['child']['child']), 'Unable to set array key');
        $this->assertEquals($value, $array['child']['child']['child'], 'Bad array key set result');
        array_set($array, null, $value);
        $this->assertEquals($value, $array, 'Bad array set result');
    }

    public function testBase62encode()
    {
        $this->assertEquals('Z', base62encode('61'), 'Bad base62encode value for 61');
        $this->assertEquals('10', base62encode('62'), 'Bad base62encode value for 62');
    }

    public function testFnGet()
    {
        $array = [
            'child' => [
                'child' => [
                    'child' => 'no child',
                ],
            ],
        ];
        $obj = json_decode(json_encode($array));
        $default = 'default';
        $this->assertEquals(
            $array['child']['child']['child'],
            fnGet($array, 'child.child.child'),
            'Unable to fetch child on array'
        );
        $this->assertEquals(
            $array['child']['child']['child'],
            fnGet($array, 'child.child.child', null, '.', true),
            'Unable to fetch child on array'
        );
        $this->assertEquals(
            $obj->child->child->child,
            fnGet($obj, 'child.child.child', null, '.', true),
            'Unable to fetch child on object'
        );
        $this->assertEquals(
            $default,
            fnGet($array, 'bad.key', $default),
            'Unable to return default value if child not found on array'
        );
        $this->assertEquals(
            $default,
            fnGet($obj, 'bad.key', $default, '.', true),
            'Unable to return default value if child not found on object'
        );
    }

    public function testUrl()
    {
        $baseUrl = Config::get('app.url');
        $uri = 'test/done';
        $expected = rtrim($baseUrl, '/') . '/' . ltrim($uri, '/');
        $this->assertEquals($expected, url($uri), 'Bad url() result');
        $expected = rtrim($baseUrl, '/') . '/' . ltrim($uri, '/') . '?k=v';
        $this->assertEquals($expected, url($uri, ['k' => 'v']), 'Bad url() result on queries');
        Config::set('app.enable_https', true);
        $expected = str_replace('http:', 'https:', rtrim($baseUrl, '/')) . '/' . ltrim($uri, '/') . '?k=v';
        $this->assertEquals($expected, url($uri, ['k' => 'v'], true), 'Bad url() result on https');
        $expected = $uri = 'http://test.com';
        $this->assertEquals($expected, url($uri), 'Bad url() result on external links');
    }
}
