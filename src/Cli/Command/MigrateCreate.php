<?php

namespace Phwoolcon\Cli\Command;

use Phwoolcon\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;

class MigrateCreate extends Command
{

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the migration')
            ->setDescription('Create a new migration script.')
            ->setAliases(['migrate:make']);
    }

    public function fire()
    {
        $filename = date('Y-m-d-His-') . $this->input->getArgument('name') . '.php';
        $path = migrationPath($filename);
        file_put_contents($path, $this->template());
        $this->output->writeln("<info>Created Migration:</info> {$filename}");
    }

    protected function template()
    {
        return file_get_contents(__DIR__ . '/Migrate/template.php');
    }
}
