<?php
namespace Phwoolcon\Exception;

class NotFoundException extends HttpRuntimeException
{

    public function __construct($message, $headers = null)
    {
        parent::__construct($message, 404, $headers);
    }
}
