<?php

namespace Phwoolcon\Cli;

use Symfony\Component\Console\Output\ConsoleOutput;

class Output extends ConsoleOutput
{

    public function comment($messages, $options = self::OUTPUT_NORMAL)
    {
        $this->writeln("<comment>{$messages}</comment>", $options);
    }

    public function error($messages, $options = self::OUTPUT_NORMAL)
    {
        $this->writeln("<error>{$messages}</error>", $options);
    }

    public function info($messages, $options = self::OUTPUT_NORMAL)
    {
        $this->writeln("<info>{$messages}</info>", $options);
    }

    public function question($messages, $options = self::OUTPUT_NORMAL)
    {
        $this->writeln("<question>{$messages}</question>", $options);
    }
}
