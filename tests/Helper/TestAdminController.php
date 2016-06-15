<?php
namespace Phwoolcon\Tests\Helper;

use Phwoolcon\Controller;
use Phwoolcon\Controller\Admin;

class TestAdminController extends Controller
{
    use Admin;

    public function getTestRoute()
    {
        $this->response->setContent('Test Admin Route Content');
    }
}
