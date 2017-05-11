<?php

namespace Phwoolcon\Cli;

use LogicException;
use Phalcon\Di;
use Phwoolcon\Cli;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class Command extends SymfonyCommand
{
    protected $di;
    /**
     * @var \Symfony\Component\Console\Input\ArgvInput
     */
    protected $input;
    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    protected $output;
    /**
     * @var SymfonyStyle
     */
    protected $interactive;

    protected $statusCode = 0;

    protected $outputTimestamp = false;

    public function __construct($name, Di $di)
    {
        $this->di = $di;
        empty($_SERVER['PHWOOLCON_CLI_OUTPUT_TIMESTAMP']) or $this->outputTimestamp = true;
        parent::__construct($name);
    }

    /**
     * @codeCoverageIgnore
     */
    public function ask($question, $default = null)
    {
        return $this->interactive->ask($question, $default);
    }

    /**
     * @codeCoverageIgnore
     */
    public function confirm($question, $default = true)
    {
        return $this->interactive->confirm($question, $default);
    }

    public function createProgressBar($max = 0)
    {
        $progress = $this->interactive->createProgressBar($max);
        $progress->setBarWidth(Cli::getConsoleWidth() - 12 - strlen($max) * 2);
        return $progress;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->interactive = new SymfonyStyle($input, $output);
        $this->fire();
        return $this->statusCode;
    }

    /**
     * @codeCoverageIgnore
     */
    public function fire()
    {
        throw new LogicException('You must override the fire() method in the concrete command class.');
    }

    /**
     * @return Di
     * @codeCoverageIgnore
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * @param Di $di
     * @return $this
     * @codeCoverageIgnore
     */
    public function setDi($di)
    {
        $this->di = $di;
        return $this;
    }

    public function comment($message)
    {
        $this->writeln("<comment>{$message}</comment>");
    }

    /**
     * @codeCoverageIgnore
     */
    public function debug($message)
    {
        $this->output->isDebug() and $this->comment($message);
    }

    /**
     * @codeCoverageIgnore
     * @param string $message
     * @param int    $statusCode
     */
    public function error($message, $statusCode = 1)
    {
        $this->outputTimestamp and $message = $this->timestampMessage($message);
        $output = $this->output instanceof ConsoleOutputInterface ? $this->output->getErrorOutput() : $this->output;
        $output->writeln("<error>{$message}</error>");
        $this->statusCode = $statusCode;
    }

    public function info($message)
    {
        $this->writeln("<info>{$message}</info>");
    }

    public function question($message)
    {
        $this->writeln("<question>{$message}</question>");
    }

    /**
     * @codeCoverageIgnore
     */
    public function verbose($message)
    {
        $this->output->isVerbose() and $this->info($message);
    }

    /**
     * @codeCoverageIgnore
     */
    public function veryVerbose($message)
    {
        $this->output->isVeryVerbose() and $this->info($message);
    }

    public function writeln($message)
    {
        $this->outputTimestamp and $message = $this->timestampMessage($message);
        $this->output->writeln($message);
    }

    protected function timestampMessage($message)
    {
        return date('[Y-m-d H:i:s] ') . $message;
    }

    /**
     * @codeCoverageIgnore
     * @param $title
     */
    protected function setCliTitle($title)
    {
        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($title);
        }
    }
}
