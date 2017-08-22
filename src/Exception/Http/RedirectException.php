<?php

namespace Phwoolcon\Exception\Http;

use Phwoolcon\Exception\HttpException;

/**
 * Throw this exception to terminate execution and response a 302 redirect
 * @package Phwoolcon\Exception\Http
 * @codeCoverageIgnore
 */
class RedirectException extends HttpException
{

    public function __construct($path, $queries = [], $secure = null)
    {
        $headers = [
            'Location' => url($path, $queries, $secure),
        ];
        parent::__construct('Moved Temporarily', 302, $headers);
    }
}
