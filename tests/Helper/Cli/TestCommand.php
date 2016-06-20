<?php
namespace Phwoolcon\Tests\Helper\Cli;

use Phwoolcon\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;

class TestCommand extends Command
{

    protected function configure()
    {
        $this->addArgument('format', InputArgument::OPTIONAL, 'The output format');
    }

    public function fire()
    {
        if ($this->input->getArgument('format') == 'question') {
            $this->question('foo');
        }
    }
}
