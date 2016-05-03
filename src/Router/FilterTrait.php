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
    public function __invoke($uri, $route, $router)
    {
        static::$instance or static::instance();
        return static::$instance->filter($uri, $route, $router);
    }

    public static function instance()
    {
        static::$instance or static::$instance = new static;
        return static::$instance;
    }
}
