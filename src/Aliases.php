<?php
namespace Phwoolcon;

use Phalcon\Di;

class Aliases
{

    public static function register(Di $di)
    {
        foreach (Config::get('app.class_aliases') as $alias => $class) {
            class_alias($class, $alias);
        }
    }
}
