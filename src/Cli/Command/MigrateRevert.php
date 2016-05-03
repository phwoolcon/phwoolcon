<?php

namespace Phwoolcon\Cli\Command;

use Phwoolcon\Cli\Command;

class MigrateRevert extends Command
{

    protected function configure()
    {
        $this->setDescription('Revert last migration.')
            ->setAliases(['migrate:down']);
    }

    public function fire()
    {
    }
}
