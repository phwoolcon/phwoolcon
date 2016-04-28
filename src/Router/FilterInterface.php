<?php

namespace Phwoolcon\Router;

use Phalcon\Mvc\Router\Route;
use Phwoolcon\Router;

interface FilterInterface
{

    /**
     * @param string $uri
     * @param Route  $route
     * @param Router $router
     * @return bool
     */
    public static function run($uri, $route, $router);
}
