<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cli;
use Phwoolcon\Tests\Helper\Cli\TestCommand;
use Phwoolcon\Tests\Helper\CliTestCase;

class CliTest extends CliTestCase
{

    public function testGetConsoleWidth()
    {
        $this->assertTrue(is_numeric(Cli::getConsoleWidth()));
    }

    public function testCommandOutputFormat()
    {
        $output = $this->runCommand('test-command', ['question']);
        $this->assertEquals('foo', trim($output));
    }
}
