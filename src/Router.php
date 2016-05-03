<?php
namespace Phwoolcon;

use Closure;
use Phalcon\Di;
use Phalcon\Http\Response;
use Phalcon\Mvc\Router as PhalconRouter;
use Phalcon\Mvc\Router\Route;
use Phwoolcon\Exception\NotFoundException;

/**
 * Class Router
 * @package Phwoolcon
 *
 * @method Route add($pattern, $paths = null, $httpMethods = null, $position = Router::POSITION_LAST)
 */
class Router extends PhalconRouter
{
    /**
     * @var Di
     */
    protected static $di;
    protected static $disableSession;
    /**
     * @var static
     */
    protected static $router;
    protected $_uriSource = self::URI_SOURCE_SERVER_REQUEST_URI;

    public function __construct()
    {
        parent::__construct(false);
        $this->removeExtraSlashes(true);
        $routes = is_file($file = static::$di['ROOT_PATH'] . '/app/routes.php') ? include $file : [];
        is_array($routes) and $this->addRoutes($routes);
    }

    public function addRoutes(array $routes, $prefix = null, $filter = null) {
        $prefix and $prefix = rtrim($prefix, '/');
        foreach ($routes as $method => $methodRoutes) {
            foreach ($methodRoutes as $uri => $handler) {
                $uri{0} == '/' or $uri = '/' . $uri;
                $prefix and $uri = $prefix . $uri;
                $uri == '/' or $uri = rtrim($uri, '/');
                $this->quickAdd($method, $uri, $handler, $filter);
            }
        }
    }

    public static function disableSession()
    {
        static::$disableSession = true;
    }

    public static function dispatch($uri = null)
    {
        static::$router === null and static::$router = static::$di->getShared('router');
        $router = static::$router;
        $router->handle($uri);
        if ($route = $router->getMatchedRoute()) {
            static::$disableSession or Session::start();
            if (($controllerClass = $router->getControllerName()) instanceof Closure) {
                $response = $controllerClass();
                if (!$response instanceof Response) {
                    /* @var Response $realResponse */
                    $realResponse = static::$di->getShared('response');
                    $realResponse->setContent($response);
                    $response = $realResponse;
                }
            } else {
                /* @var Controller $controller */
                $controller = new $controllerClass;
                method_exists($controller, 'initialize') and $controller->initialize();
                method_exists($controller, $method = $router->getActionName()) or static::throw404Exception();
                $controller->{$method}();
                $response = $controller->response;
            }
            Session::end();
            return $response;
        }
        static::throw404Exception();
        return false;
    }

    public static function generate404Page()
    {
        return View::make('errors', '404', ['page_title' => '404 NOT FOUND']);
    }

    public function prefix($prefix, array $routes, $filter = null)
    {
        $this->addRoutes($routes, $prefix, $filter);
        return $this;
    }

    public function quickAdd($method, $uri, $handler, $filter = null)
    {
        $uri{0} == '/' or $uri = '/' . $uri;
        if (is_array($handler)) {
            if (!$filter && isset($handler['filter'])) {
                $filter = $handler['filter'];
                unset($handler['filter']);
            }
            empty($handler['controller']) and $handler = reset($handler);
        }
        if (is_string($handler)) {
            list($controller, $action) = explode('::', $handler);
            $handler = compact('controller', 'action');
        } else if ($handler instanceof Closure) {
            $handler = ['controller' => $handler];
        }
        $method == 'ANY' and $method = null;
        $method == 'GET' and $method = ['GET', 'HEAD'];
        $route = $this->add($uri, $handler, $method);
        is_callable($filter) or $filter = null;
        $filter and $route->beforeMatch($filter);
        return $route;
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->setShared('router', function () {
            return new static();
        });
    }

    public static function throw404Exception($content = null, $contentType = 'text/html')
    {
        $content or $content = static::generate404Page();
        throw new NotFoundException($content, ['content-type' => $contentType]);
    }
}
