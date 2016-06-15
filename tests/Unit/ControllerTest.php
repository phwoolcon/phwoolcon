<?php
namespace Phwoolcon\Tests\Unit;

use Exception;
use Phalcon\Http\Response;
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
        return new TestController();
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
        $this->getView()->reset();
        $controller->addPageTitle('Phwoolcon');
        $controller->addPageTitle('Test Title');
        $controller->render('test', 'controller-render');
        $this->assertEquals('Test Title - Phwoolcon', View::getPageTitle());
    }

    public function testRender()
    {
        $controller = $this->getTestController();
        $this->getView()->reset();
        $controller->render('test', 'controller-render');
        $this->assertEquals('TEST CONTROLLER RENDER', $controller->response->getContent());
    }

    public function testJsonReturn()
    {
        $controller = $this->getTestController();
        $this->getView()->reset();
        $controller->testJsonReturn($data = [
            'foo' => 'bar',
        ]);
        $this->assertEquals(json_encode($data), $controller->response->getContent());
    }
}
