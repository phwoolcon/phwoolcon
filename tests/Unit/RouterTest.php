<?php
namespace Phwoolcon\Tests\Unit;

use Exception;
use Phalcon\Http\Response;
use Phwoolcon\Cache\Clearer;
use Phwoolcon\Config;
use Phwoolcon\Cookies;
use Phwoolcon\Exception\Http\CsrfException;
use Phwoolcon\Exception\Http\ForbiddenException;
use Phwoolcon\Exception\Http\NotFoundException;
use Phwoolcon\Log;
use Phwoolcon\Router;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\View;

class RouterTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Router::register($this->di);
        View::register($this->di);
    }

    public function tearDown()
    {
        unset($_SERVER['REQUEST_METHOD']);
        parent::tearDown();
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        return $this->di->getShared('router');
    }

    /**
     * @return View
     */
    protected function getView()
    {
        return $this->di->getShared('view');
    }

    /**
     * @param string $uri
     * @param string $method
     * @return CsrfException|NotFoundException|Response
     */
    protected function dispatch($uri, $method = 'GET')
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $router = $this->getRouter();
        $router::staticReset();
        Cookies::reset();
        $this->getView()->reset();
        try {
            return $router->dispatch($uri);
        } catch (Exception $e) {
            Log::exception($e);
            return $e;
        }
    }

    public function test404Routes()
    {
        $response = $this->dispatch('/404');
        $this->assertInstanceOf(NotFoundException::class, $response);
        $this->assertEquals('404 NOT FOUND', $response->toResponse()->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testClosureRoutes()
    {
        $response = $this->dispatch('/test-closure-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Closure Route Content', $response->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testControllerRoutes()
    {
        $response = $this->dispatch('/test-controller-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Controller Route Content', $response->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testRegexRoutes()
    {
        $expected = var_export([
            $what = 'regex',
            'what' => $what,
        ], 1);
        $response = $this->dispatch("/test/{$what}/regex-route");
        $this->assertEquals($expected, $response->getContent());

        $expected = var_export([
            $what = 'foo',
            'what' => $what,
        ], 1);
        $response = $this->dispatch("/test/{$what}/regex-route");
        $this->assertEquals($expected, $response->getContent());
    }

    public function testFilteredRoutes()
    {
        $response = $this->dispatch('/test-filtered-route', 'POST');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Controller Route Content', $response->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testFailedFilterRoutes()
    {
        $response = $this->dispatch('/test-failed-filter-route', 'POST');
        $this->assertInstanceOf(NotFoundException::class, $response);
        $this->assertEquals('404 NOT FOUND', $response->toResponse()->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testExceptionFilterRoutes()
    {
        $response = $this->dispatch('/test-exception-filter-route', 'GET');
        $this->assertInstanceOf(ForbiddenException::class, $response);
        $response = $response->toResponse();
        $this->assertEquals('ALWAYS EXCEPTION', $response->getContent());
        $this->assertEquals('bar', $response->getHeaders()->get('foo'));
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testCsrfCheck()
    {
        $response = $this->dispatch('/test-csrf-check', 'POST');
        $this->assertInstanceOf(CsrfException::class, $response);
        $this->assertEquals('403 FORBIDDEN', $response->toResponse()->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testPrefixedRoutes()
    {
        $response = $this->dispatch('/prefix/test-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Prefixed Route Content', $response->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testAdminRoutes()
    {
        $response = $this->dispatch('/admin/test-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Admin Route Content', $response->getContent());
        $this->assertTrue($this->getView()->isAdmin());
    }

    public function testApiRoutes()
    {
        $response = $this->dispatch('/api/test-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Api Route Content', $response->getContent());
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testApiDataRoutes()
    {
        $response = $this->dispatch('/api/test-json-api-data');
        $this->assertInstanceOf(Response::class, $response);
        $content = $response->getContent();
        $this->assertContains(json_encode([
            'id' => 1,
            'type' => 'entity',
            'attributes' => [
                'foo' => 'bar',
            ],
        ]), $content);
        $this->assertContains('jsonapi', $content);
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testApiErrorRoutes()
    {
        $response = $this->dispatch('/api/test-json-api-error');
        $this->assertInstanceOf(Response::class, $response);
        $content = $response->getContent();
        $this->assertContains(json_encode([
            [
                'code' => 'foo',
                'title' => 'bar',
            ],
        ]), $content);
        $this->assertContains('jsonapi', $content);
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testApiMetaRoutes()
    {
        $response = $this->dispatch('/api/test-json-api-meta');
        $this->assertInstanceOf(Response::class, $response);
        $content = $response->getContent();
        $this->assertContains(json_encode([
            'meta_foo' => 'bar',
        ]), $content);
        $this->assertContains('jsonapi', $content);
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testApi404Routes()
    {
        $response = $this->dispatch('/api/404');
        $this->assertInstanceOf(NotFoundException::class, $response);
        $content = $response->toResponse()->getContent();
        $this->assertContains(json_encode([
            'status' => 404,
            'code' => 404,
            'title' => '404 Not Found',
        ]), $content);
        $this->assertContains('jsonapi', $content);
        $this->assertFalse($this->getView()->isAdmin());
    }

    public function testGenerateErrorPage()
    {
        $this->assertEquals('404 NOT FOUND', Router::generateErrorPage('404', '404 PAGE TITLE'));
    }

    public function testCachedRoutes()
    {
        Config::set('app.cache_routes', true);
        Clearer::clear(Clearer::TYPE_ROUTES);
        Router::register($this->di);
        $this->testClosureRoutes();
        Clearer::clear(Clearer::TYPE_ROUTES);
        Config::set('app.cache_routes', false);
    }
}
