<?php

namespace Phwoolcon\Cli\Command;

use Phwoolcon\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
        // @codeCoverageIgnoreStart
        if (is_file($migrationCandidates = $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor/phwoolcon/migrations.php')) {
            $candidates = include $migrationCandidates;
            if (count($candidates['candidates']) == 1) {
                $path = reset($candidates['candidates']) . '/' . $filename;
            } elseif (count($candidates['candidates']) > 1) {
                $targets = array_merge([''], array_keys($candidates['candidates']));
                unset($targets[0]);
                $firstCandidate = reset($targets);
                $default = empty($candidates['selected']) ? $firstCandidate : $candidates['selected'];
                isset($candidates['candidates'][$default]) or $default = $firstCandidate;
                $choose = $this->interactive->choice('Please choose migration target: ', $targets, $default);
                $candidates['selected'] = $choose;
                fileSaveArray($migrationCandidates, $candidates);
                $path = $candidates['candidates'][$choose] . '/' . $filename;
            }
        }
        // @codeCoverageIgnoreEnd
        file_put_contents($path, $this->template());
        $this->output->writeln("<info>Created Migration:</info> {$filename}");
    }

    public function template()
    {
        return file_get_contents(__DIR__ . '/Migrate/template.php');
    }
}
