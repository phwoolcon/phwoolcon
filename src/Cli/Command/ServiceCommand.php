<?php

namespace Phwoolcon\Cli\Command;

use Phalcon\Di;
use Phwoolcon\Cli\Command;
use Phwoolcon\Daemon\Service;
use Symfony\Component\Console\Input\InputArgument;

class ServiceCommand extends Command
{

    protected function configure()
    {
        $this->setDefinition([
            new InputArgument(
                'action',
                InputArgument::OPTIONAL,
                "Specifies the action to the service. Should be one of :
start | stop | restart | reload | status | install | uninstall"
            ),
        ])->setDescription('Phwoolcon High Performance Service');
    }

    public function fire()
    {
        Service::register($this->di);
        /* @var Service $service */
        $service = $this->di->getShared('service');
        $service->setCliCommand($this);
        $serviceName = $service->getName();
        switch (strtolower($this->input->getArgument('action'))) {
            case 'start':
                $this->comment("Starting {$serviceName}...");
                $service->start();
                break;
            case 'stop':
                $this->comment("Stopping {$serviceName}...");
                $service->stop();
                break;
            case 'restart':
                $this->comment("Stopping {$serviceName}...");
                $service->stop();
                sleep(1);
                $this->comment("Starting {$serviceName}...");
                $service->start();
                break;
            case 'reload':
                $this->comment('Run: bin/cli service reload-create-new-instance');
                $this->comment('then bin/cli service reload-shut-old-instance');
                break;
            case 'reload-create-new-instance':
                $this->comment("Starting new {$serviceName}...");
                $service->shift()
                    ->start();
                break;
            case 'reload-shut-old-instance':
                // Ensure new service instance is up
                $port = $service->choosePort();
                $retry = 0;
                $service->sendCommand('status', $port, $error);
                while ($error && $retry < 20) {
                    usleep(5e5);
                    ++$retry;
                    $service->sendCommand('status', $port, $error);
                }
                if ($error) {
                    $this->error('Service reload failed: ' . var_export($error, true));
                    break;
                }
                $this->comment("Stopping old {$serviceName}...");
                $service->stop('old');
                $this->info('Service reloaded.');
                break;
            case 'status':
                $service->showStatus();
                break;
            case 'install':
                $service->install();
                break;
            case 'uninstall':
            case 'remove':
                $service->uninstall();
                break;
            default:
                $this->info($this->getDescription());
                $this->comment('Usage:');
                $this->info('bin/cli service [ start | stop | restart | reload | status | install | uninstall ]');
                $this->output->writeln('');
        }
    }
}
