<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Tests\TestCase;

class I18nTest extends TestCase
{
    protected $eventChangeValue = false;

    public function setUp()
    {
        parent::setUp();
    }

    public function testTranslate()
    {
        $this->assertEquals('测试', __('Test'));
    }
}
