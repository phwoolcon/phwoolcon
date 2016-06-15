<?php
namespace Phwoolcon\Tests\Helper;

use Phwoolcon\Controller;
use Phwoolcon\Controller\Api;

class TestApiController extends Controller
{
    use Api;

    public function getTestRoute()
    {
        $this->response->setContent('Test Api Route Content');
    }
}
