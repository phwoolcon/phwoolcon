<?php
namespace Phwoolcon;

use Closure;
use Phalcon\Di;
use Phalcon\Http\Response;
use Phalcon\Mvc\Router as PhalconRouter;
use Phwoolcon\Exception\NotFoundException;

class Router extends PhalconRouter
{
    /**
     * @var Di
     */
    protected static $di;
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
        foreach ($routes as $method => $methodRoutes) {
            $method == 'ANY' and $method = null;
            foreach ($methodRoutes as $uri => $handler) {
                if (is_string($handler)) {
                    list($controller, $action) = explode('::', $handler);
                    $handler = compact('controller', 'action');
                } else if ($handler instanceof Closure) {
                    $handler = ['controller' => $handler];
                }
                $this->add($uri, $handler, $method);
            }
        }
    }

    public static function dispatch($uri = null)
    {
        static::$router === null and static::$router = static::$di->getShared('router');
        $router = static::$router;
        $router->handle($uri);
        if ($router->getMatchedRoute()) {
            if (($controllerClass = $router->getControllerName()) instanceof Closure) {
                $response = $controllerClass();
                if (!$response instanceof Response) {
                    $response = new Response($response);
                }
            } else {
                /* @var Controller $controller */
                $controller = new $controllerClass;
                method_exists($controller, 'initialize') and $controller->initialize();
                method_exists($controller, $method = $router->getActionName()) or static::throw404Exception();
                $controller->{$method}();
                $response = $controller->response;
            }
            return $response;
        }
        static::throw404Exception();
        return false;
    }

    public static function generate404Page()
    {
        return View::make('errors', '404', ['page_title' => '404 NOT FOUND']);
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
