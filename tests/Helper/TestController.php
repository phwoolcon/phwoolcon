<?php
namespace Phwoolcon\Tests\Helper;

use Phwoolcon\Controller;

class TestController extends Controller
{

    public function getTestRoute()
    {
        $this->response->setContent('Test Controller Route Content');
    }

    public function getTestPrefixedRoute()
    {
        $this->response->setContent('Test Prefixed Route Content');
    }

    public function getTestInput()
    {
        $this->response->setContent($this->input('key'));
    }

    public function testJsonReturn($data)
    {
        $this->jsonReturn($data);
    }

    public function testInput($key, $default = null)
    {
        return $this->input($key, $default);
    }

    public function testRedirect($url)
    {
        $this->redirect($url);
    }

    public function testSetBrowserCache($pageId, $type = null)
    {
        $this->setBrowserCache($pageId, $type);
    }

    public function testGetBrowserCache($pageId, $type = null)
    {
        return $this->getBrowserCache($pageId, $type);
    }
}
