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

    public function testJsonReturn($data)
    {
        $this->jsonReturn($data);
    }
}
