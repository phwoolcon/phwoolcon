<?php

namespace Phwoolcon\Cli\Command;

use Exception;
use Phwoolcon\Db;
use Phwoolcon\Log;
use Symfony\Component\Console\Input\InputOption;

class MigrateList extends Migrate
{

    protected function configure()
    {
        $this->setDescription('List available migrations.')
            ->addOption('installed', 'i', InputOption::VALUE_NONE, 'List installed migrations')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'List available and installed migrations');
    }

    public function fire()
    {
        $this->checkMigrationsTable();
        if ($this->input->getOption('installed')) {
            $this->listMigrated();
        } elseif ($this->input->getOption('all')) {
            $this->listMigrated();
            $this->listToBeMigrated();
        } else {
            $this->listToBeMigrated();
        }
    }

    protected function listMigrated()
    {
        $this->loadMigrated();
        if ($this->migrated) {
            $this->comment('Following migrations are installed:');
            $this->interactive->table(['Script', 'Run at'], $this->rawMigrated);
        } else {
            $this->info('No migrations installed.');
        }
        return $this;
    }

    protected function listToBeMigrated()
    {
        $found = false;
        foreach (glob(migrationPath('*.php')) as $file) {
            $filename = basename($file);
            if ($this->migrationExecuted($filename)) {
                continue;
            }
            $found or $this->comment('Following migrations are ready for install:');
            $found = true;
            $this->info($filename);
        }
        $found or $this->info('Nothing to be migrated.');
        return $this;
    }
}
