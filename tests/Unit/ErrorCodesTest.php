<?php

namespace Phwoolcon\Tests\Unit\Util;

use Exception;
use LogicException;
use Phwoolcon\ErrorCodes;
use Phwoolcon\I18n;
use Phwoolcon\Tests\Helper\TestCase;
use UnexpectedValueException;

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

    public function testThrowException()
    {
        $exception = UnexpectedValueException::class;
        $e = null;
        try {
            ErrorCodes::throw1234($exception);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf($exception, $e);
        $this->assertEquals(1234, $e->getCode());
        $this->assertEquals('Test numeric error code', $e->getMessage());

        $exception = LogicException::class;
        $e = null;
        try {
            ErrorCodes::throwTestError($exception);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf($exception, $e);
        $this->assertEquals(0, $e->getCode());
        $this->assertEquals('Test error message [test_error]', $e->getMessage());
    }

    public function testIdeHelperGenerator()
    {
        $ideHelper = ErrorCodes::ideHelperGenerator();
//        echo PHP_EOL, $ideHelper, PHP_EOL;
//        exit;
        $this->assertEquals(<<<'METHOD'
    public static function getTestError() {
        return ['test_error', 'Test error message'];
    }

    public static function throwTestError($exception) {
        throw new $exception('Test error message [test_error]', 0);
    }

    public static function getTestParam($param, $anotherParam) {
        return ['test_param', 'Test error message with %param% and %another_param%'];
    }

    public static function throwTestParam($exception, $param, $anotherParam) {
        throw new $exception('Test error message with %param% and %another_param% [test_param]', 0);
    }

    public static function get1234() {
        return ['1234', 'Test numeric error code'];
    }

    public static function throw1234($exception) {
        throw new $exception('Test numeric error code', 1234);
    }
METHOD
            , $ideHelper);
    }
}
