<?php

namespace Phwoolcon\Session;

interface AdapterInterface
{

    public function end();

    public function readCookieAndStart();

    public function setCookie();
}
