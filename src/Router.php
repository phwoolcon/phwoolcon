<?php
namespace Phwoolcon;

use Closure;
use Phalcon\Di;
use Phalcon\Http\Response;
use Phalcon\Mvc\Router as PhalconRouter;

class Router extends PhalconRouter
{
    /**
     * @var static
     */
    protected static $router;
    protected $_uriSource = self::URI_SOURCE_SERVER_REQUEST_URI;

    public function __construct($defaultRoutes = false, Di $di)
    {
        parent::__construct($defaultRoutes);

        $routes = include $di['ROOT_PATH'] . '/app/routes.php';
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
        static::$router === null and static::$router = Di::getDefault()->getShared('router');
        $router = static::$router;
        $router->handle($uri);
        if ($router->getMatchedRoute()) {
            if (($controllerClass = $router->getControllerName()) instanceof Closure) {
                $response = $controllerClass();
                if (!$response instanceof Response) {
                    $response = new Response($response);
                }
            } else {
                $controller = new $controllerClass;
                method_exists($controller, 'initialize') and $controller->initialize();
                method_exists($controller, $method = $router->getActionName()) or throw404Exception();
                $controller->{$method}();
                $response = $controller->response;
            }
            /* @var $response \Phalcon\Http\Response */
            $response->send();
        } else {
            throw404Exception();
        }
    }

    public static function register(Di $di)
    {
        $di->setShared('router', function () use ($di) {
            $router = new Router(false, $di);
            $router->removeExtraSlashes(true);
            return $router;
        });
    }
}
