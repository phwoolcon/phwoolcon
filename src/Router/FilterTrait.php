<?php

namespace Phwoolcon\Router;

use Phalcon\Mvc\Router\Route;
use Phwoolcon\Router;

trait FilterTrait
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @param string $uri
     * @param Route  $route
     * @param Router $router
     * @return bool
     */
    abstract protected function filter($uri, $route, $router);

    /**
     * @param string $uri
     * @param Route  $route
     * @param Router $router
     * @return bool
     */
    public static function run($uri, $route, $router)
    {
        static::$instance or static::$instance = new static;
        return static::$instance->filter($uri, $route, $router);
    }
}
