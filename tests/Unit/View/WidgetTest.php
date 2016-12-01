<?php
namespace Phwoolcon\Tests\Unit\View;

use Phalcon\Tag;
use Phwoolcon\Exception\WidgetException;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\View\Widget;

class WidgetTest extends TestCase
{

    public function testLabel()
    {
        $widget = Widget::label(['for' => 'world'], 'Hello');
        $this->assertEquals('<label for="world">Hello</label>', $widget);
    }

    public function testSingleSelect()
    {
        // Check required field
        $e = null;
        try {
            Widget::singleChoose([]);
        } catch (WidgetException $e) {
        }
        $this->assertInstanceOf(WidgetException::class, $e);
        $this->assertContains('id', $e->getMessage());

        $e = null;
        try {
            Widget::singleChoose(['id' => 'hello']);
        } catch (WidgetException $e) {
        }
        $this->assertInstanceOf(WidgetException::class, $e);
        $this->assertContains('options', $e->getMessage());

        // Test expanded single choose
        $widget = Widget::singleChoose([
            'id' => 'hello',
            'name' => 'data[hello]',
            'options' => [
                'hello' => 'world',
                'foo' => 'bar',
            ],
        ]);
        $this->assertStringStartsWith('<input ', $widget);
        $this->assertContains('input type="radio" id="hello_0" name="data[hello]" value="hello"', $widget);
        $this->assertContains('<label for="hello_0">world</label>', $widget);
        $this->assertContains('input type="radio" id="hello_1" name="data[hello]" value="foo"', $widget);
        $this->assertContains('<label for="hello_1">bar</label>', $widget);

        // Test checked expanded single choose with label on left
        $widget = Widget::singleChoose([
            'id' => 'hello',
            'name' => 'data[hello]',
            'value' => 'hello',
            'labelOn' => 'left',
            'options' => [
                'hello' => 'world',
                'foo' => 'bar',
            ],
        ]);
        $this->assertStringStartsWith('<label ', $widget);
        $expected = 'input type="radio" id="hello_0" name="data[hello]" value="hello" checked="checked"';
        $this->assertContains($expected, $widget);
        $this->assertContains('<label for="hello_0">world</label>', $widget);
        $this->assertContains('input type="radio" id="hello_1" name="data[hello]" value="foo"', $widget);
        $this->assertContains('<label for="hello_1">bar</label>', $widget);

        // Test single choose with select
        $widget = Widget::singleChoose([
            'id' => 'hello',
            'name' => 'data[hello]',
            'expand' => false,
            'options' => [
                'hello' => 'world',
                'foo' => 'bar',
            ],
        ]);
        $this->assertContains('select id="hello" name="data[hello]"', $widget);
        $this->assertContains('<option value="hello">world</option>', $widget);
        $this->assertContains('<option value="foo">bar</option>', $widget);

        // Test selected single choose with select
        $widget = Widget::singleChoose([
            'id' => 'hello',
            'name' => 'data[hello]',
            'value' => 'hello',
            'expand' => false,
            'options' => [
                'hello' => 'world',
                'foo' => 'bar',
            ],
        ]);
        $this->assertContains('select id="hello" name="data[hello]"', $widget);
        $this->assertContains('<option selected="selected" value="hello">world</option>', $widget);
        $this->assertContains('<option value="foo">bar</option>', $widget);
    }

    public function testUndefinedWidget()
    {
        $e = null;
        try {
            Widget::someWhat([]);
        } catch (WidgetException $e) {
        }
        $this->assertInstanceOf(WidgetException::class, $e);
        $this->assertContains('undefined', $e->getMessage(), '', true);
        $this->assertContains('someWhat', $e->getMessage());
    }

    public function testDefine()
    {
        Widget::define('hello', function ($parameters) {
            $innerHtml = isset($parameters['innerHtml']) ? $parameters['innerHtml'] : '';
            unset($parameters['innerHtml']);
            return Tag::tagHtml('hello', $parameters) . $innerHtml . Tag::tagHtmlClose('hello');
        });
        $widget = Widget::hello(['data-hello' => 'world']);
        $this->assertEquals('<hello data-hello="world"></hello>', $widget);
    }

    public function testIdeGenerator()
    {
        Widget::define('hello', function (
            array $parameters,
            &$null = null,
            $true = true,
            $false = false,
            $const = PHP_EOL,
            \stdClass $class = null,
            callable $callable = null
        ) {
            $innerHtml = isset($parameters['innerHtml']) ? $parameters['innerHtml'] : '';
            unset($parameters['innerHtml']);
            return Tag::tagHtml('hello', $parameters) . $innerHtml . Tag::tagHtmlClose('hello');
        });
        $expected = '    public static function hello(array $parameters, &$null = null, ' .
            '$true = true, $false = false, $const = PHP_EOL, stdClass $class = null, callable $callable = null) {}';
        $this->assertEquals($expected, Widget::ideHelperGenerator());
    }
}
