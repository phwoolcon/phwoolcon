<?php
namespace Phwoolcon\Cli\Command;

use Phwoolcon\Cache\Clearer;
use Phwoolcon\Cli\Command;
use Symfony\Component\Console\Input\InputOption;

class ClearCacheCommand extends Command
{

    protected function configure()
    {
        $definition = [];
        $shotCuts = [];
        foreach (Clearer::getTypes() as $type => $label) {
            $shotCut = isset($shotCuts[$type{0}]) ? null : $type{0};
            $shotCuts[$shotCut] = true;
            $definition[] = new InputOption($type, $shotCut, InputOption::VALUE_NONE, $label);
        }
        $this->setDefinition($definition)->setDescription('Clears cache');
    }

    public function fire()
    {
        $types = array_keys(array_filter($this->input->getOptions()));
        foreach (Clearer::clear($types) as $message) {
            $this->info($message);
        }
    }
}
