<?php

namespace Phwoolcon\Tests\Unit\Util;

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

    public function testGenerateException()
    {
        $exception = UnexpectedValueException::class;
        $e = ErrorCodes::gen1234($exception);
        $this->assertInstanceOf($exception, $e);
        $this->assertEquals(1234, $e->getCode());
        $this->assertEquals('Test numeric error code', $e->getMessage());

        $exception = LogicException::class;
        $e = ErrorCodes::genTestError($exception);
        $this->assertInstanceOf($exception, $e);
        $this->assertEquals(0, $e->getCode());
        $this->assertEquals('Test error message [test_error]', $e->getMessage());
    }

    public function testNumericCodeWithAnnotation()
    {
        list($code, $message) = ErrorCodes::get2345WithAnnotation();
        $this->assertEquals($expectedCode = '2345', $code);
        $this->assertEquals($expectedMessage = 'Test numeric error code with annotation', $message);

        $exception = LogicException::class;
        $e = ErrorCodes::gen2345WithAnnotation($exception);
        $this->assertInstanceOf($exception, $e);
        $this->assertEquals($expectedCode, $e->getCode());
        $this->assertEquals($expectedMessage, $e->getMessage());
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

    public static function genTestError($exception) {
        return new $exception('Test error message [test_error]', 0);
    }

    public static function getTestParam($param, $anotherParam) {
        return ['test_param', 'Test error message with %param% and %another_param%'];
    }

    public static function genTestParam($exception, $param, $anotherParam) {
        return new $exception('Test error message with %param% and %another_param% [test_param]', 0);
    }

    public static function get1234() {
        return ['1234', 'Test numeric error code'];
    }

    public static function gen1234($exception) {
        return new $exception('Test numeric error code', 1234);
    }

    public static function get2345WithAnnotation() {
        return ['2345', 'Test numeric error code with annotation'];
    }

    public static function gen2345WithAnnotation($exception) {
        return new $exception('Test numeric error code with annotation', 2345);
    }
METHOD
            , $ideHelper);
    }
}
