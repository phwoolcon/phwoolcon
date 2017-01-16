<?php
namespace Phwoolcon;

use Closure;
use Opis\Closure\SerializableClosure;
use Phalcon\Di;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Router as PhalconRouter;
use Phalcon\Mvc\Router\Exception;
use Phalcon\Mvc\Router\Route;
use Phwoolcon\Daemon\ServiceAwareInterface;
use Phwoolcon\Exception\Http\CsrfException;
use Phwoolcon\Exception\Http\NotFoundException;
use Phwoolcon\Exception\HttpException;

/**
 * Class Router
 * @package Phwoolcon
 *
 * @property Route[] $_routes
 * @method Route add($pattern, $paths = null, $httpMethods = null, $position = Router::POSITION_LAST)
 */
class Router extends PhalconRouter implements ServiceAwareInterface
{
    /**
     * @var Di
     */
    protected static $di;
    protected static $disableSession = false;
    protected static $disableCsrfCheck = false;
    protected static $runningUnitTest = false;
    protected static $useLiteHandler = true;
    protected static $currentUri = null;
    /**
     * @var Request
     */
    protected static $request;
    /**
     * @var static
     */
    protected static $router;
    protected $_uriSource = self::URI_SOURCE_SERVER_REQUEST_URI;
    protected $_sitePathPrefix;
    protected $_sitePathLength;

    protected static $cacheFile;

    /**
     * @var Response\Cookies
     */
    protected $cookies;
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Route[][]
     */
    protected $exactRoutes;

    /**
     * @var Route[][]
     */
    protected $regexRoutes;

    public function __construct()
    {
        parent::__construct(false);
        static::$runningUnitTest = Config::runningUnitTest();
        static::$useLiteHandler = Config::get('app.use_lite_router');
        // @codeCoverageIgnoreStart
        if ($this->_sitePathPrefix = Config::get('app.site_path')) {
            $this->_uriSource = self::URI_SOURCE_GET_URL;
            $this->_sitePathLength = strlen($this->_sitePathPrefix);
        }
        // @codeCoverageIgnoreEnd
        $this->removeExtraSlashes(true);
        if (Config::get('app.cache_routes')) {
            if (!$this->loadLocalCache()) {
                $this->loadRoutes();
                $this->saveLocalCache();
            }
        } else {
            $this->loadRoutes();
        }
        $this->cookies = static::$di->getShared('cookies');
        $this->response = static::$di->getShared('response');
        $this->response->setStatusCode(200);
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
        static::$request or static::$request = static::$di->getShared('request');
        $request = static::$request;
        if ($request->isPost() && $request->get('_token') != Session::getCsrfToken()) {
            self::throwCsrfException();
        }
    }

    public static function clearCache()
    {
        is_file($file = static::$cacheFile) and unlink($file);
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
                if (substr($uri, 0, $router->_sitePathLength) == $router->_sitePathPrefix) {
                    $uri = substr($uri, $router->_sitePathLength);
                }
            }
            // @codeCoverageIgnoreEnd
            Events::fire('router:before_dispatch', $router, ['uri' => $uri]);

            $realUri = $uri === null ? $router->getRewriteUri() : $uri;
            $handledUri = $realUri === '/' ? $realUri : rtrim($realUri, '/');
            static::$currentUri = $handledUri;

            static::$useLiteHandler ? $router->liteHandle($handledUri) : $router->handle($handledUri);
            ($route = $router->getMatchedRoute()) or static::throw404Exception();
            static::$disableSession or Session::start();
            $controllerClass = $router->getControllerName();
            $controllerClass instanceof SerializableClosure and $controllerClass = $controllerClass->getClosure();
            if ($controllerClass instanceof Closure) {
                static::$disableCsrfCheck or static::checkCsrfToken();
                $response = $controllerClass();
                if (!$response instanceof Response) {
                    /* @var Response $realResponse */
                    $realResponse = $router->response;
                    $realResponse->setContent($response);
                    $response = $realResponse;
                }
            } else {
                /* @var Controller $controller */
                $controller = new $controllerClass;
                method_exists($controller, 'initialize') and $controller->initialize();
                static::$disableCsrfCheck or static::checkCsrfToken();
                method_exists($controller, $method = $router->getActionName()) or static::throw404Exception();
                $controller->{$method}();
                $response = $controller->response;
            }
            Events::fire('router:after_dispatch', $router, ['response' => $response]);
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

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public static function getCurrentUri()
    {
        return self::$currentUri;
    }

    public function liteHandle($uri)
    {
        static::$request or static::$request = static::$di->getShared('request');
        $request = static::$request;

        $this->exactRoutes === null and $this->splitRoutes();

        $this->_matches = null;
        $this->_wasMatched = true;
        $this->_matchedRoute = null;

        $this->_namespace = $this->_defaultNamespace;
        $this->_module = $this->_defaultModule;
        $this->_controller = $this->_defaultController;
        $this->_action = $this->_defaultAction;
        $this->_params = $this->_defaultParams;

        $httpMethod = $request->getMethod();
        $matchedRoute = null;
        if (isset($this->exactRoutes[$httpMethod][$uri])) {
            $matchedRoute = $this->exactRoutes[$httpMethod][$uri];
            if ($beforeMatch = $matchedRoute->getBeforeMatch()) {
                if (!call_user_func_array($beforeMatch, [$uri, $matchedRoute, $this])) {
                    $matchedRoute = null;
                }
            }
        }
        if ($matchedRoute === null) {
            $regexRoutes = isset($this->regexRoutes[$httpMethod]) ? $this->regexRoutes[$httpMethod] : [];
            foreach ($regexRoutes as $pattern => $route) {
                if (preg_match($pattern, $uri, $matches)) {
                    if ($beforeMatch = $route->getBeforeMatch()) {
                        // @codeCoverageIgnoreStart
                        if (!call_user_func_array($beforeMatch, [$uri, $route, $this])) {
                            continue;
                        }
                        // @codeCoverageIgnoreEnd
                    }

                    $paths = $route->getPaths();
                    $parts = $paths;

                    foreach ($paths as $part => $position) {
                        $isPositionInt = is_int($position);
                        $isPositionString = is_string($position);
                        if (!$isPositionInt && !$isPositionString) {
                            continue;
                        }

                        if (isset($matches[$position])) {
                            /**
                             * Update the parts
                             */
                            $parts[$part] = $matches[$position];
                        } else {
                            /**
                             * Remove the path if the parameter was not matched
                             */
                            // @codeCoverageIgnoreStart
                            if ($isPositionInt) {
                                unset($parts[$part]);
                            }
                            // @codeCoverageIgnoreEnd
                        }
                    }

                    /**
                     * Update the matches generated by preg_match
                     */
                    $this->_matches = $matches;

                    $matchedRoute = $route;
                    break;
                }
            }
        }
        if ($matchedRoute) {
            $this->_matchedRoute = $matchedRoute;
            $this->_wasMatched = true;

            isset($paths) or $paths = $matchedRoute->getPaths();
            isset($parts) or $parts = $paths;

            /**
             * Check for a namespace
             */
            if (isset($parts['namespace'])) {
                $namespace = $parts['namespace'];
                if (!is_numeric($namespace)) {
                    $this->_namespace = $namespace;
                }
                unset($parts['namespace']);
            }

            /**
             * Check for a module
             */
            if (isset($parts['module'])) {
                $module = $parts['module'];
                if (!is_numeric($module)) {
                    $this->_module = $module;
                }
                unset($parts['module']);
            }

            /**
             * Check for a controller
             */
            if (isset($parts['controller'])) {
                $controller = $parts['controller'];
                if (!is_numeric($controller)) {
                    $this->_controller = $controller;
                }
                unset($parts['controller']);
            }

            /**
             * Check for an action
             */
            if (isset($parts['action'])) {
                $action = $parts['action'];
                if (!is_numeric($action)) {
                    $this->_action = $action;
                }
                unset($parts['action']);
            }

            $params = [];
            /**
             * Check for parameters
             */
            if (isset($parts['params'])) {
                $paramsStr = $parts['params'];
                if (is_string($paramsStr)) {
                    $strParams = trim($paramsStr, '/');
                    if ($strParams !== '') {
                        $params = explode('/', $strParams);
                    }
                }
                unset($parts['params']);
            }

            if ($params) {
                $this->_params = array_merge($params, $parts);
            } else {
                $this->_params = $parts;
            }
        }
    }

    protected function loadLocalCache()
    {
        if (!is_file(static::$cacheFile)) {
            return false;
        }
        try {
            if ($routes = include static::$cacheFile) {
                $this->_routes = unserialize($routes);
                return true;
            }
        } // @codeCoverageIgnoreStart
        catch (\Exception $e) {
            Log::exception($e);
        }
        return false;
        // @codeCoverageIgnoreEnd
    }

    protected function loadRoutes()
    {
        $this->_routes = [];
        $routes = is_file($file = $_SERVER['PHWOOLCON_ROOT_PATH'] . '/app/routes.php') ? include $file : [];
        is_array($routes) and $this->addRoutes($routes);
    }

    public function prefix($prefix, array $routes, $filter = null)
    {
        $this->addRoutes($routes, $prefix, $filter);
        return $this;
    }

    public function quickAdd($method, $uri, $handler, $filter = null)
    {
        $uri{0} == '/' or $uri = '/' . $uri;
        if ($isArrayHandler = is_array($handler)) {
            if (!$filter && isset($handler['filter'])) {
                $filter = $handler['filter'];
                unset($handler['filter']);
            }
            empty($handler['controller']) and $handler = reset($handler);
        }
        if (is_string($handler)) {
            list($controller, $action) = explode('::', $handler);
            $handler = ['controller' => $controller, 'action' => $action];
        } elseif ($handler instanceof Closure) {
            $handler = ['controller' => new SerializableClosure($handler)];
        } elseif ($isArrayHandler && isset($handler['controller']) && $handler['controller'] instanceof Closure) {
            $handler['controller'] = new SerializableClosure($handler['controller']);
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
        static::$cacheFile = storagePath('cache/routes.php');
        $di->remove('router');
        $di->setShared('router', function () {
            return new static();
        });
    }

    public function reset()
    {
        static::$disableSession = false;
        static::$disableCsrfCheck = false;
        static::$currentUri = null;
        $this->cookies->reset();
        $this->response->setContent('')
            ->resetHeaders()
            ->setStatusCode(200);
    }

    protected function saveLocalCache()
    {
        fileSaveArray(static::$cacheFile, serialize($this->_routes));
    }

    protected function splitRoutes()
    {
        $exactRoutes = [];
        $regexRoutes = [];
        /* @var Route[] $routes */
        $routes = array_reverse($this->_routes);
        foreach ($routes as $route) {
            $pattern = $route->getCompiledPattern();
            $methods = (array)$route->getHttpMethods();
            $methods or $methods = ['GET', 'HEAD', 'POST', 'PUT', 'DELETE'];
            if ($pattern{0} === '#') {
                foreach ($methods as $method) {
                    isset($regexRoutes[$method][$pattern]) or $regexRoutes[$method][$pattern] = $route;
                }
            } else {
                foreach ($methods as $method) {
                    isset($exactRoutes[$method][$pattern]) or $exactRoutes[$method][$pattern] = $route;
                }
            }
        }
        $this->exactRoutes = $exactRoutes;
        $this->regexRoutes = $regexRoutes;
    }

    public static function staticReset()
    {
        static::$router === null and static::$router = static::$di->getShared('router');
        static::$router->reset();
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

    /**
     * @codeCoverageIgnore
     */
    public static function useLiteHandler($flag = null)
    {
        $flag === null or static::$useLiteHandler = (bool)$flag;
        return static::$useLiteHandler;
    }
}
