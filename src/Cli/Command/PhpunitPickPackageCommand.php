<?php

namespace Phwoolcon\Cli\Command;

use Phwoolcon\Cli\Command;
use Symfony\Component\Console\Input\InputOption;

class PhpunitPickPackageCommand extends Command
{

    protected function configure()
    {
        $this->setDescription('Pick a phwoolcon package for phpunit testing.')
            ->addOption('clear', 'c', InputOption::VALUE_NONE, 'Clear chosen result');
    }

    public function fire()
    {
        $outputFile = storagePath('phpunit-chosen-package');

        if ($this->input->getOption('clear')) {
            is_file($outputFile) and unlink($outputFile);
            return;
        }

        $packages = [''];
        $packageFiles = detectPhwoolconPackageFiles();
        $rootPathLength = strlen($_SERVER['PHWOOLCON_ROOT_PATH']) + 1;
        foreach ($packageFiles as $packageFile) {
            $packages[] = substr(dirname(dirname($packageFile)), $rootPathLength);
        }
        unset($packages[0]);
        $firstOption = reset($packages);
        $default = is_file($outputFile) ? file_get_contents($outputFile) : $firstOption;
        in_array($default, $packages) or $default = $firstOption;
        $package = $this->interactive->choice('Run phpunit for ... ', $packages, $default);

        file_put_contents($outputFile, $package);
    }
}
