<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cli;
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

    public function testProgressBar()
    {
        $output = $this->runCommand('test-command', ['progress']);
        $lines = explode("\n", trim($output));

        $this->assertStringStartsWith('0/10', trim($lines[0]));
        $this->assertContains('0%', trim($lines[0]));

        $this->assertStringStartsWith('1/10', trim($lines[1]));
        $this->assertContains('10%', trim($lines[1]));

        $this->assertStringStartsWith('2/10', trim($lines[2]));
        $this->assertContains('20%', trim($lines[2]));
    }

    public function testTimestampMessage()
    {
        $output = $this->runCommand('test-command', ['TimestampMessage']);
        $this->assertStringStartsWith(date('[Y-m-d'), $output);
        $this->assertStringEndsWith('foo', trim($output));
    }
}
