<?php

namespace Phwoolcon\Cli;

use Phalcon\Di;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand
{
    protected $di;

    public function __construct($name, Di $di)
    {
        $this->di = $di;
        parent::__construct($name);
    }

    /**
     * @return Di
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * @param Di $di
     * @return $this
     */
    public function setDi($di)
    {
        $this->di = $di;
        return $this;
    }
}
