<?php
namespace Phwoolcon\Tests\Unit;

use Exception;
use Phalcon\Http\Response;
use Phwoolcon\Cookies;
use Phwoolcon\Exception\Http\CsrfException;
use Phwoolcon\Exception\Http\ForbiddenException;
use Phwoolcon\Exception\Http\NotFoundException;
use Phwoolcon\Router;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Tests\Helper\TestController;
use Phwoolcon\View;

class ControllerTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Router::register($this->di);
        View::register($this->di);
    }

    protected function getTestController()
    {
        $this->getView()->reset();
        $controller = new TestController();
        Cookies::reset();
        $controller->response->resetHeaders()->setContent(null);
        return $controller;
    }

    /**
     * @return View
     */
    protected function getView()
    {
        return $this->di->getShared('view');
    }

    public function testPageTitle()
    {
        $controller = $this->getTestController();
        $controller->addPageTitle('Phwoolcon');
        $controller->addPageTitle('Test Title');
        $controller->render('test', 'controller-render');
        $this->assertEquals('Test Title - Phwoolcon', View::getPageTitle());
    }

    public function testRender()
    {
        $controller = $this->getTestController();
        $controller->render('test', 'controller-render');
        $this->assertEquals('TEST CONTROLLER RENDER', $controller->response->getContent());
    }

    public function testJsonReturn()
    {
        $controller = $this->getTestController();
        $controller->testJsonReturn($data = [
            'foo' => 'bar',
        ]);
        $this->assertEquals(json_encode($data), $controller->response->getContent());
    }

    public function testInput()
    {
        $controller = $this->getTestController();
        $oldRequest = $_REQUEST;
        $_REQUEST[$key = 'foo'] = $value = 'bar';
        $result = $controller->testInput($key);
        $_REQUEST = $oldRequest;
        $this->assertEquals($value, $result);
        $this->assertNull($controller->testInput('non-existing'));
        $this->assertEquals($value, $controller->testInput('non-existing', $value));
    }

    public function testRedirect()
    {
        $controller = $this->getTestController();
        $controller->testRedirect($url = 'test-url');
        $this->assertStringStartsWith('302', $controller->response->getHeaders()->get('Status'));
        $this->assertEquals(url($url), $controller->response->getHeaders()->get('Location'));
    }

    public function testBrowserCache()
    {
        $controller = $this->getTestController();
        $pageId = 'test-browser-cache';
        $controller->response->setContent($content = 'Test browser cache');
        $controller->testSetBrowserCache($pageId);
        $cachedContent = $controller->testGetBrowserCache($pageId);
        $eTag = fnGet($cachedContent, 'etag');
        $this->assertEquals($content, fnGet($cachedContent, 'content'));
        $this->assertEquals($eTag, $controller->response->getHeaders()->get('Etag'));

        $cachedContentNonExisting = $controller->testGetBrowserCache('non-existing');
        $this->assertNull(fnGet($cachedContentNonExisting, 'content'));

        $controller2 = $this->getTestController();
        $pageId2 = 'test-browser-cache-2';
        $controller2->response->setContent($content2 = 'Test browser cache 2');
        $cachedContent2 = $controller2->testGetBrowserCache('non-existing');
        $this->assertNull(fnGet($cachedContent2, 'content'));
        $controller2->testSetBrowserCache($pageId2, $controller2::BROWSER_CACHE_ETAG);
        $eTag = $controller2->getBrowserCache($pageId2, $controller2::BROWSER_CACHE_ETAG);
        $this->assertEquals($eTag, $controller2->response->getHeaders()->get('Etag'));
        $controller2->testSetBrowserCache($pageId2, $controller2::BROWSER_CACHE_CONTENT);
        $this->assertEquals($content2, $controller2->getBrowserCache($pageId2, $controller2::BROWSER_CACHE_CONTENT));
    }
}
