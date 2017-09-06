<?php

namespace Phwoolcon\Cli\Command\Package;

use PharData;
use Phwoolcon\Cli\Command;

/**
 * Command to create a Phwoolcon package
 *
 * @package Phwoolcon\Cli\Command\Package
 * @codeCoverageIgnore
 */
class CreateCommand extends Command
{

    protected function configure()
    {
        $this->setDescription('Create a phwoolcon package under vendor dir.');
    }

    public function fire()
    {
        // Clear working dir
        if (is_dir($workingDir = storagePath('package-skeleton'))) {
            removeDir($workingDir);
        }

        // Extract skeleton
        mkdir($workingDir, 0777, true);
        $phar = new PharData(__DIR__ . '/skeleton.tar');
        $phar->extractTo($workingDir);

        // Run prefill script
        $workingDir .= '/skeleton';
        chdir($workingDir);
        putenv('PHWOOLCON_ROOT_PATH=' . $_SERVER['PHWOOLCON_ROOT_PATH']);
        $process = proc_open('php prefill-phwoolcon.php', [STDIN, STDOUT, STDERR], $pipes);
        proc_close($process);
        if (is_file($workingDir . '/prefill-phwoolcon.php')) {
            $this->error('Error occurred while running `prefill-phwoolcon.php`');
        }
    }
}
