<?php
namespace Phwoolcon\Tests\Unit;

use Exception;
use Phalcon\Http\Response;
use Phwoolcon\Exception\Http\CsrfException;
use Phwoolcon\Exception\Http\NotFoundException;
use Phwoolcon\Router;
use Phwoolcon\Tests\Helper\TestCase;

class RouterTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Router::register($this->di);
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        return $this->di->getShared('router');
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
        $router::reset();
        try {
            return $router->dispatch($uri);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function test404Routes()
    {
        $response = $this->dispatch('/404');
        $this->assertInstanceOf(NotFoundException::class, $response);
        $this->assertEquals('404 NOT FOUND', $response->toResponse()->getContent());
    }

    public function testClosureRoutes()
    {
        $response = $this->dispatch('/test-closure-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Closure Route Content', $response->getContent());
    }

    public function testControllerRoutes()
    {
        $response = $this->dispatch('/test-controller-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Controller Route Content', $response->getContent());
    }

    public function testFilteredRoutes()
    {
        $response = $this->dispatch('/test-filtered-route', 'POST');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Controller Route Content', $response->getContent());
    }

    public function testFailedFilterRoutes()
    {
        $response = $this->dispatch('/test-failed-filter-route', 'POST');
        $this->assertInstanceOf(NotFoundException::class, $response);
        $this->assertEquals('404 NOT FOUND', $response->toResponse()->getContent());
    }

    public function testCsrfCheck()
    {
        $response = $this->dispatch('/test-csrf-check', 'POST');
        $this->assertInstanceOf(CsrfException::class, $response);
        $this->assertEquals('403 FORBIDDEN', $response->toResponse()->getContent());
    }

    public function testPrefixedRoutes()
    {
        $response = $this->dispatch('/prefix/test-route');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('Test Prefixed Route Content', $response->getContent());
    }
}
