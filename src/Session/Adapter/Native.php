<?php

namespace Phwoolcon\Session\Adapter;

use Phalcon\Session\Adapter\Files;
use Phwoolcon\Config;
use Phwoolcon\Session\StartTrait;

class Native extends Files
{
    use StartTrait;

    public function __construct($options = null)
    {
        parent::__construct($options);
        session_save_path($options['save_path']);
    }
}
