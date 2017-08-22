<?php

namespace Phwoolcon\Exception\Http;

/**
 * Throw this exception to terminate execution and response a 403 forbidden when CSRF verification failed
 * @package Phwoolcon\Exception\Http
 */
class CsrfException extends ForbiddenException
{
}
