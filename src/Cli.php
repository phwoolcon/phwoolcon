<?php

namespace Phwoolcon;

use Phalcon\Di;
use Symfony\Component\Console\Application;

class Cli
{
    protected static $consoleWidth;

    public static function register(Di $di)
    {
        $app = new Application(Config::get('app.name'), Config::get('app.version'));
        foreach (Config::get('commands') as $name => $class) {
            // @codeCoverageIgnoreStart
            if (!class_exists($class)) {
                fwrite(STDERR, "[Warning] commands config: Class {$class} not found for {$name}" . PHP_EOL);
                continue;
            }
            // @codeCoverageIgnoreEnd
            $app->add(new $class($name, $di));
        }
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        return $app;
    }

    public static function getConsoleWidth()
    {
        if (!static::$consoleWidth) {
            static::$consoleWidth = (int)`tput cols`;
            static::$consoleWidth > 30 or static::$consoleWidth = 80;
        }
        return static::$consoleWidth;
    }
}
