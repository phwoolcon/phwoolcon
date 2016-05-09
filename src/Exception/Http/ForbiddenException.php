<?php
namespace Phwoolcon\Exception\Http;

use Phwoolcon\Exception\HttpException;

class ForbiddenException extends HttpException
{

    public function __construct($message, $headers = null)
    {
        parent::__construct($message, 403, $headers);
    }
}
