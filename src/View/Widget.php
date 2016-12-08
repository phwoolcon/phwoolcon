<?php
namespace Phwoolcon\View;

use Closure;
use Phalcon\Tag;
use Phwoolcon\Exception\WidgetException;
use Phwoolcon\Util\Reflection\Stringify\Parameter;
use ReflectionFunction;

/**
 * Class Widget
 * @package Phwoolcon\View
 *
 * @method static string label(array $parameters, string $innerHtml)
 * @uses    Widget::builtInLabel()
 * @method static string multipleChoose(array $parameters)
 * @uses    Widget::builtInMultipleChoose()
 * @method static string singleChoose(array $parameters)
 * @uses    Widget::builtInSingleChoose()
 */
class Widget
{
    protected static $builtInWidgets = [];

    /**
     * @var callable[]
     */
    protected static $widgets = [];

    public static function define($name, callable $definition)
    {
        static::$widgets[$name] = $definition;
    }

    public static function __callStatic($name, $arguments)
    {
        if (isset(static::$widgets[$name])) {
            return call_user_func_array(static::$widgets[$name], $arguments);
        } elseif (isset(static::$builtInWidgets[$name])) {
            return call_user_func_array(static::$builtInWidgets[$name], $arguments);
        } elseif (method_exists(static::class, $method = 'builtIn' . $name)) {
            static::$builtInWidgets[$name] = $widget = [static::class, $method];
            return call_user_func_array($widget, $arguments);
        } else {
            throw new WidgetException(__('Undefined widget "%name%"', ['name' => $name]));
        }
    }

    /**
     * Make a label element
     *
     * Required parameters:
     * $innerHtml
     * Optional parameters:
     * 'for', 'class', or other html attributes
     *
     * @param array  $parameters
     * @param string $innerHtml
     * @return string
     */
    protected static function builtInLabel(array $parameters, $innerHtml)
    {
        return Tag::tagHtml('label', $parameters, false, true) . $innerHtml . Tag::tagHtmlClose('label');
    }

    /**
     * Make a multiple select widget, if options < 5 it will be expanded into radios by default
     *
     * Required parameters:
     * 'id', 'options' (in array)
     * Optional parameters:
     * 'name', 'class', 'value' (selected value) or other html attributes
     * 'expand' (true or false, by default 'auto')
     * 'useEmpty', 'emptyText' (used in select mode)
     * 'prefix', 'suffix' (used to wrap radios in expanded mode)
     * 'labelOn' ('left' or 'right', by default 'right', used to identify radios in expanded mode)
     *
     * @param array $parameters
     * @return string
     */
    protected static function builtInMultipleChoose(array $parameters)
    {
        static::checkRequiredParameters($parameters, ['id', 'options']);
        $options = (array)$parameters['options'];
        $parameters[0] = $id = $parameters['id'];
        $expand = isset($parameters['expand']) ? $parameters['expand'] : 'auto';
        unset($parameters['options'], $parameters['expand']);

        // Expand select into radio buttons
        if ($expand === true || ($expand == 'auto' && count($options) < 5)) {
            $html = [];
            $i = 0;
            $radioParams = $parameters;
            $labelOn = isset($radioParams['labelOn']) ? $radioParams['labelOn'] : 'right';
            $prefix = isset($radioParams['prefix']) ? $radioParams['prefix'] : '';
            $suffix = isset($radioParams['suffix']) ? $radioParams['suffix'] : '';
            unset($radioParams['expand'], $radioParams['labelOn'], $radioParams['prefix'], $radioParams['suffix']);
            unset($radioParams['options'], $radioParams['useEmpty'], $radioParams['emptyText']);
            $selected = isset($parameters['value']) ? array_flip((array)$parameters['value']) : [];
            foreach ($options as $value => $label) {
                $radioParams['id'] = $radioId = $id . '_' . $i;
                $radioParams['value'] = $value;
                if (isset($selected[(string)$value])) {
                    $radioParams['checked'] = 'checked';
                } else {
                    $radioParams['checked'] = null;
                }
                $checkbox = Tag::checkField($radioParams);
                if ($labelOn == 'right') {
                    $checkbox .= PHP_EOL . $label;
                } else {
                    $checkbox = $label . PHP_EOL . $checkbox;
                }
                $checkbox = static::label(['for' => $radioId], $checkbox);
                ++$i;
                $html[] = $prefix . $checkbox . $suffix;
            }
            return implode(PHP_EOL, $html);
        }
        $parameters['multiple'] = true;
        return Tag::select($parameters, $options);
    }

    /**
     * Make a single select widget, if options < 5 it will be expanded into radios by default
     *
     * Required parameters:
     * 'id', 'options' (in array)
     * Optional parameters:
     * 'name', 'class', 'value' (selected value) or other html attributes
     * 'expand' (true or false, by default 'auto')
     * 'useEmpty', 'emptyText' (used in select mode)
     * 'prefix', 'suffix' (used to wrap radios in expanded mode)
     * 'labelOn' ('left' or 'right', by default 'right', used to identify radios in expanded mode)
     *
     * @param array $parameters
     * @return string
     */
    protected static function builtInSingleChoose(array $parameters)
    {
        static::checkRequiredParameters($parameters, ['id', 'options']);
        $options = (array)$parameters['options'];
        $parameters[0] = $id = $parameters['id'];
        $expand = isset($parameters['expand']) ? $parameters['expand'] : 'auto';
        unset($parameters['options'], $parameters['expand']);

        // Expand select into radio buttons
        if ($expand === true || ($expand == 'auto' && count($options) < 5)) {
            $html = [];
            $i = 0;
            $radioParams = $parameters;
            $labelOn = isset($radioParams['labelOn']) ? $radioParams['labelOn'] : 'right';
            $prefix = isset($radioParams['prefix']) ? $radioParams['prefix'] : '';
            $suffix = isset($radioParams['suffix']) ? $radioParams['suffix'] : '';
            unset($radioParams['expand'], $radioParams['labelOn'], $radioParams['prefix'], $radioParams['suffix']);
            unset($radioParams['options'], $radioParams['useEmpty'], $radioParams['emptyText']);
            $selected = isset($parameters['value']) ? (string)$parameters['value'] : '';
            foreach ($options as $value => $label) {
                $radioParams['id'] = $radioId = $id . '_' . $i;
                $radioParams['value'] = $value;
                if ((string)$value === $selected) {
                    $radioParams['checked'] = 'checked';
                } else {
                    $radioParams['checked'] = null;
                }
                $radio = Tag::radioField($radioParams);
                if ($labelOn == 'right') {
                    $radio .= PHP_EOL . $label;
                } else {
                    $radio = $label . PHP_EOL . $radio;
                }
                $radio = static::label(['for' => $radioId], $radio);
                ++$i;
                $html[] = $prefix . $radio . $suffix;
            }
            return implode(PHP_EOL, $html);
        }
        return Tag::select($parameters, $options);
    }

    protected static function checkRequiredParameters(array $parameters, array $requiredFields)
    {
        foreach ($requiredFields as $field) {
            if (!isset($parameters[$field])) {
                throw new WidgetException(__('"%field%" field is required', ['field' => $field]));
            }
        }
    }

    public static function ideHelperGenerator()
    {
        $classContent = [];
        foreach (static::$widgets as $name => $definition) {
            $parameters = [];
            if ($definition instanceof Closure) {
                $reflection = new ReflectionFunction($definition);
                foreach ($reflection->getParameters() as $param) {
                    $parameters[] = Parameter::cast($param);
                }
            }
            $parameters = implode(', ', $parameters);
            $classContent[] = "    public static function {$name}({$parameters}) {}";
        }
        return implode(PHP_EOL . PHP_EOL, $classContent);
    }
}
