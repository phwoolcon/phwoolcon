<?php

namespace Phwoolcon\Router\Filter;

use Phalcon\Mvc\Router\Route;
use Phwoolcon\Router;
use Phwoolcon\Router\FilterInterface;
use Phwoolcon\Router\FilterTrait;

class DisableCsrfFilter implements FilterInterface
{

    use FilterTrait;

    /**
     * @param string $uri
     * @param Route  $route
     * @param Router $router
     * @return bool
     */
    protected function filter($uri, $route, $router)
    {
        Router::disableCsrfCheck();
        return true;
    }
}
