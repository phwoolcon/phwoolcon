<?php

namespace Phwoolcon\Cli;

use LogicException;
use Phalcon\Di;
use Phwoolcon\Cli;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
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

    public function __construct($name, Di $di)
    {
        $this->di = $di;
        parent::__construct($name);
    }

    public function ask($question, $default = null)
    {
        return $this->interactive->ask($question, $default);
    }

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
    }

    public function fire()
    {
        throw new LogicException('You must override the fire() method in the concrete command class.');
    }

    /**
     * @return Di
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * @param Di $di
     * @return $this
     */
    public function setDi($di)
    {
        $this->di = $di;
        return $this;
    }

    public function comment($messages)
    {
        $this->output->writeln("<comment>{$messages}</comment>");
    }

    public function error($messages)
    {
        $this->output->writeln("<error>{$messages}</error>");
    }

    public function info($messages)
    {
        $this->output->writeln("<info>{$messages}</info>");
    }

    public function question($messages)
    {
        $this->output->writeln("<question>{$messages}</question>");
    }
}
