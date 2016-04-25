<?php

namespace Phwoolcon;

use Phalcon\Di;
use Symfony\Component\Console\Application;

class Cli
{

    public static function register(Di $di)
    {
        $app = new Application('Phwoolcon', '0.0.1');
        foreach (Config::get('commands') as $name => $class) {
            $app->add(new $class($name, $di));
        }
        return $app;
    }
}
