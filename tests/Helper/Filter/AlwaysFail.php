<?php
namespace Phwoolcon\Tests\Helper\Filter;

use Phwoolcon\Router\FilterInterface;
use Phwoolcon\Router\FilterTrait;

class AlwaysFail implements FilterInterface
{
    use FilterTrait;

    protected function filter($uri, $route, $router)
    {
        return false;
    }
}
