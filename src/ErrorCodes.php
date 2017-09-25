<?php

namespace Phwoolcon;

use Phalcon\Di;

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

    protected $errors = [];

    public function __construct()
    {
    }

    public static function __callStatic($name, $arguments)
    {
        static::$instance or static::$instance = static::$di->getShared('error_codes');
        if (Text::startsWith($name, 'get')) {
            $errorCode = Text::uncamelize(substr($name, 3));
            return call_user_func([static::$instance, 'getDetails'], $errorCode, $arguments);
        }
        // @codeCoverageIgnoreStart
        return call_user_func_array([static::$instance, $name], $arguments);
        // @codeCoverageIgnoreEnd
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

    protected function detectPlaceholders($message)
    {
        $pattern = '/%([^%]*)%/';
        preg_match_all($pattern, $message, $matches);
        $placeholders = isset($matches[1]) ? $matches[1] : [];
        return $placeholders;
    }
}
