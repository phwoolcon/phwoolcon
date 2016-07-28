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

    public function getJsonApiData()
    {
        $this->jsonApiReturnData([
            'id' => 1,
            'type' => 'entity',
            'attributes' => [
                'foo' => 'bar',
            ],
        ]);
    }

    public function getJsonApiError()
    {
        $this->jsonApiReturnErrors([
            [
                'code' => 'foo',
                'title' => 'bar',
            ],
        ]);
    }

    public function getJsonApiMeta()
    {
        $this->jsonApiReturnMeta([
            'meta_foo' => 'bar',
        ]);
    }
}
