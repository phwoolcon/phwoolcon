<?php

namespace Phwoolcon\Tests\Unit\Util;

use Phwoolcon\ErrorCodes;
use Phwoolcon\I18n;
use Phwoolcon\Tests\Helper\TestCase;

class ErrorCodesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        I18n::staticReset();
        ErrorCodes::register($this->di);
    }

    public function testGetDetails()
    {
        list($code, $message) = ErrorCodes::getTestError();
        $this->assertEquals('test_error', $code);
        $this->assertEquals('Test error message', $message);

        list($code, $message) = ErrorCodes::getTestParam('foo', 'bar');
        $this->assertEquals('test_param', $code);
        $this->assertEquals('Test error message with foo and bar', $message);
    }

    public function testIdeHelperGenerator()
    {
        $ideHelper = ErrorCodes::ideHelperGenerator();
        $this->assertEquals(<<<'METHOD'
    public static function getTestError() {
        return ['test_error', 'Test error message'];
    }

    public static function getTestParam($param, $anotherParam) {
        return ['test_param', 'Test error message with %param% and %another_param%'];
    }
METHOD
            , $ideHelper);
    }
}
