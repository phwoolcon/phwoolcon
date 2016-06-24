<?php
namespace Phwoolcon;

use Closure;
use Phalcon\Di;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Router as PhalconRouter;
use Phalcon\Mvc\Router\Route;
use Phwoolcon\Exception\Http\CsrfException;
use Phwoolcon\Exception\Http\NotFoundException;
use Phwoolcon\Exception\HttpException;

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
    protected static $disableSession = false;
    protected static $disableCsrfCheck = false;
    protected static $runningUnitTest = false;
    /**
     * @var static
     */
    protected static $router;
    protected $_uriSource = self::URI_SOURCE_SERVER_REQUEST_URI;
    protected $_sitePathPrefix;
    protected $_sitePathLength;

    public function __construct()
    {
        parent::__construct(false);
        static::$runningUnitTest = Config::runningUnitTest();
        // @codeCoverageIgnoreStart
        if ($this->_sitePathPrefix = Config::get('app.site_path')) {
            $this->_uriSource = self::URI_SOURCE_GET_URL;
            $this->_sitePathLength = strlen($this->_sitePathPrefix);
        }
        // @codeCoverageIgnoreEnd
        $this->removeExtraSlashes(true);
        $routes = is_file($file = $_SERVER['PHWOOLCON_ROOT_PATH'] . '/app/routes.php') ? include $file : [];
        is_array($routes) and $this->addRoutes($routes);
    }

    public function addRoutes(array $routes, $prefix = null, $filter = null)
    {
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

    public static function checkCsrfToken()
    {
        /* @var Request $request */
        $request = static::$di->getShared('request');
        if ($request->isPost() && $request->get('_token') != Session::getCsrfToken()) {
            self::throwCsrfException();
        }
    }

    public static function disableCsrfCheck()
    {
        static::$disableCsrfCheck = true;
    }

    public static function disableSession()
    {
        static::$disableSession = true;
    }

    public static function dispatch($uri = null)
    {
        try {
            static::$router === null and static::$router = static::$di->getShared('router');
            $router = static::$router;
            // @codeCoverageIgnoreStart
            if (!$uri && $router->_sitePathLength && $router->_uriSource == self::URI_SOURCE_GET_URL) {
                list($uri) = explode('?', $_SERVER['REQUEST_URI']);
                $uri = str_replace(basename($_SERVER['SCRIPT_FILENAME']), '', $uri);
                substr($uri, 0, $router->_sitePathLength) == $router->_sitePathPrefix and $uri = substr($uri, $router->_sitePathLength);
            }
            // @codeCoverageIgnoreEnd
            $router->handle($uri);
            ($route = $router->getMatchedRoute()) or static::throw404Exception();
            static::$disableSession or Session::start();
            static::$disableCsrfCheck or static::checkCsrfToken();
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
        } catch (HttpException $e) {
            Log::exception($e);
            return static::$runningUnitTest ? $e : $e->toResponse();
        }
    }

    public static function generateErrorPage($template, $pateTitle)
    {
        return View::make('errors', $template, ['page_title' => $pateTitle]);
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
        } elseif ($handler instanceof Closure) {
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
        $di->remove('router');
        $di->setShared('router', function () {
            return new static();
        });
    }

    public static function reset()
    {
        static::$disableSession = false;
        static::$disableCsrfCheck = false;
    }

    public static function throw404Exception($content = null, $contentType = 'text/html')
    {
        !$content && static::$runningUnitTest and $content = '404 NOT FOUND';
        $content or $content = static::generateErrorPage('404', '404 NOT FOUND');
        throw new NotFoundException($content, ['content-type' => $contentType]);
    }

    public static function throwCsrfException($content = null, $contentType = 'text/html')
    {
        !$content && static::$runningUnitTest and $content = '403 FORBIDDEN';
        $content or $content = static::generateErrorPage('csrf', '403 FORBIDDEN');
        throw new CsrfException($content, ['content-type' => $contentType]);
    }
}
