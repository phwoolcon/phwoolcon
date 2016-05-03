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
    public function __invoke($uri, $route, $router);
}
