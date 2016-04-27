<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Session\Adapter\Files;
use Phwoolcon\Config;
use Phwoolcon\Session\AdapterInterface;
use Phwoolcon\Session\AdapterTrait;

class Native extends Files implements AdapterInterface
{
    use AdapterTrait;

    public function __construct($options = null)
    {
        parent::__construct($options);
        session_save_path($options['save_path']);
    }
}
