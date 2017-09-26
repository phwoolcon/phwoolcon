<?php

namespace Phwoolcon;

use Phalcon\Di;

/**
 * Class ErrorCodes
 *
 * Usage:
 * 1. Define error codes in a locale file `error_codes.php`
 * ```php
 * <?php
 * return [
 *     'foo_error' => 'The foo error message: %param%',
 *     '1234' => 'Some error message for 1234',
 * ];
 * ```
 * 2. `bin/dump-autoload` to generate the IDE helper
 * 3. Enjoy the magic methods:
 * ```php
 * <?php
 *
 * use ErrorCodes; // Use the alias instead of Phwoolcon\ErrorCodes;
 *
 * list($errorCode, $errorMessage) = ErrorCodes::getFooError('bar');
 * var_dump($errorCode, $errorMessage);             // prints 'foo_error' and 'The foo error message: bar'
 *
 * throw ErrorCodes::gen1234(RuntimeException::class); // This is identical to:
 *                                                  // $errorMessage = 'Some error message for 1234';
 *                                                  // $errorCode = 1234;
 *                                                  // throw new RuntimeException($errorMessage, $errorCode)
 *
 * throw ErrorCodes::genFooError(RuntimeException::class, 'bar'); // This is identical to:
 *                                                  // $errorMessage = 'The foo error message: bar [foo_error]';
 *                                                  // $errorCode = 0; // Error code in a exception must be a integer
 *                                                  // throw new RuntimeException($errorMessage, $errorCode)
 * ```
 *
 * @package Phwoolcon
 */
class ErrorCodes
{

    /**
     * @var Di
     */
    protected static $di;

    /**
     * @var static
     */
    protected static $instance;

    public static function __callStatic($name, $arguments)
    {
        static::$instance or static::$instance = static::$di->getShared('error_codes');
        if (Text::startsWith($name, 'get', false)) {
            $errorCode = Text::uncamelize(substr($name, 3));
            return call_user_func([static::$instance, 'getDetails'], $errorCode, $arguments);
        }
        if (Text::startsWith($name, 'gen', false)) {
            $errorCode = Text::uncamelize(substr($name, 3));
            $exception = array_shift($arguments);
            return call_user_func([static::$instance, 'generateException'], $exception, $errorCode, $arguments);
        }
        // @codeCoverageIgnoreStart
        return call_user_func_array([static::$instance, $name], $arguments);
        // @codeCoverageIgnoreEnd
    }

    protected static function detectPlaceholders($message)
    {
        $pattern = '/%([^%]*)%/';
        preg_match_all($pattern, $message, $matches);
        $placeholders = isset($matches[1]) ? $matches[1] : [];
        return $placeholders;
    }

    public static function ideHelperGenerator()
    {
        $classContent = [];
        /* @var I18n $i18n */
        $i18n = static::$di->getShared('i18n');
        $locales = $i18n->loadLocale(I18n::getCurrentLocale());
        $errorCodes = fnGet($locales, 'packages.error_codes', []);
        foreach ($errorCodes as $code => $message) {
            $name = Text::camelize((string)$code);
            $parameters = array_map(function ($field) {
                return '$' . lcfirst(Text::camelize((string)$field));
            }, static::detectPlaceholders($message));
            $exceptionCode = (int)$code;
            $exceptionMessage = $message;
            is_numeric($code) or $exceptionMessage .= ' [' . $code . ']';
            $exceptionParameters = $parameters;
            array_unshift($exceptionParameters, '$exception');
            $parameters = implode(', ', $parameters);
            $exceptionParameters = implode(', ', $exceptionParameters);
            $classContent[] = <<<METHOD
    public static function get{$name}({$parameters}) {
        return ['{$code}', '{$message}'];
    }

    public static function gen{$name}({$exceptionParameters}) {
        return new \$exception('{$exceptionMessage}', {$exceptionCode});
    }
METHOD;
        }
        return implode(PHP_EOL . PHP_EOL, $classContent);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('error_codes');
        static::$instance = null;
        $di->setShared('error_codes', function () {
            return new static;
        });
    }

    protected function generateException($exception, $errorCode, array $arguments)
    {
        $errorMessage = $this->getDetails($errorCode, $arguments)[1];
        is_numeric($errorCode) or $errorMessage .= ' [' . $errorCode . ']';
        return new $exception($errorMessage, (int)$errorCode);
    }

    protected function getDetails($errorCode, array $arguments)
    {
        $errorMessage = __($errorCode, null, $package = 'error_codes');
        if (count($arguments)) {
            $params = [];
            reset($arguments);
            foreach ($this->detectPlaceholders($errorMessage) as $placeholder) {
                $params[$placeholder] = current($arguments);
                next($arguments);
                if (key($arguments) === null) {
                    break;
                }
            }
            $errorMessage = __($errorCode, $params, $package);
        }
        return [$errorCode, $errorMessage];
    }
}
