<?php
namespace Phwoolcon\Tests\Helper\Cli;

use Phwoolcon\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;

class TestCommand extends Command
{

    protected function configure()
    {
        $this->addArgument('action', InputArgument::OPTIONAL, 'The test action');
    }

    public function fire()
    {
        $action = $this->input->getArgument('action');
        $this->{'test' . ucfirst($action)}();
    }

    public function testProgress()
    {
        $progress = $this->createProgressBar(10);
        $progress->start();
        $progress->advance();
        $progress->advance();
    }

    public function testQuestion()
    {
        $this->question('foo');
    }

    public function testTimestampMessage()
    {
        $this->outputTimestamp = true;
        $this->info('foo');
        $this->outputTimestamp = false;
    }
}
