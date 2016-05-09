<?php
namespace Phwoolcon\Exception\Http;

use Phwoolcon\Exception\HttpException;

class NotFoundException extends HttpException
{

    public function __construct($message, $headers = null)
    {
        parent::__construct($message, 404, $headers);
    }
}
