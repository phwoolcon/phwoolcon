<?php

namespace Phwoolcon\Controller;

use Phwoolcon\Router;

trait Api
{

    public function initialize()
    {
    }

    public function missingMethod()
    {
        Router::throw404Exception(json_encode([
            'error_code' => 404,
            'error_msg' => '404 Not Found',
        ]), 'application/json');
    }
}
