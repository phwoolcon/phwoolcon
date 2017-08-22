<?php
namespace Phwoolcon\Exception\Http;

use Phwoolcon\Exception\HttpException;

/**
 * Throw this exception to terminate execution and response a 403 forbidden
 * @package Phwoolcon\Exception\Http
 */
class ForbiddenException extends HttpException
{

    public function __construct($message, $headers = null)
    {
        parent::__construct($message, 403, $headers);
    }
}
