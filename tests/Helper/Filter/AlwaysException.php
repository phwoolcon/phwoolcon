<?php
namespace Phwoolcon\Tests\Helper\Filter;

use Phwoolcon\Exception\Http\ForbiddenException;
use Phwoolcon\Router\FilterInterface;
use Phwoolcon\Router\FilterTrait;

class AlwaysException implements FilterInterface
{
    use FilterTrait;

    protected function filter($uri, $route, $router)
    {
        throw new ForbiddenException('ALWAYS EXCEPTION', 'foo: bar');
    }
}
