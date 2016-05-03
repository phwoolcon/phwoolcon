<?php

namespace Phwoolcon\Cli\Command;

use Phalcon\Di;
use Phwoolcon\Cli\Command;

class Migrate extends Command
{

    protected function configure()
    {
        $this->setDescription('Run migration scripts.')
            ->setAliases(['migrate:up']);
    }

    public function fire()
    {
    }
}
