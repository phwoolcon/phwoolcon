<?php

namespace Phwoolcon;

use Phalcon\Di;
use Symfony\Component\Console\Application;

class Cli
{

    public static function register(Di $di)
    {
        $app = new Application();
        foreach (Config::get('commands') as $name => $class) {
            $app->add(new $class($name, $di));
        }
        return $app;
    }
}
