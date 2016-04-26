<?php

namespace Phwoolcon\Controller;

use Phwoolcon\Controller;
use Phwoolcon\Router;

abstract class Api extends Controller
{

    public function initialize()
    {}

    public function missingMethod()
    {
        Router::throw404Exception(json_encode([
            'error_code' => 404,
            'error_msg' => '404 Not Found',
        ]), 'application/json');
    }
}
