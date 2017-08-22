<?php

namespace Phwoolcon\Exception\Http;

use Phwoolcon\Exception\HttpException;

/**
 * Throw this exception to terminate execution and response a 404 not found
 * @package Phwoolcon\Exception\Http
 */
class NotFoundException extends HttpException
{

    public function __construct($message, $headers = null)
    {
        parent::__construct($message, 404, $headers);
    }
}
