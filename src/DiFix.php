<?php
namespace Phwoolcon;

use Closure;
use Phalcon\Di;
use Phalcon\Events\Event;

class DiFix extends Di
{

    /**
     * Fix over clever di service resolver in phalcon 2.1.x:
     * let definition = \Closure::bind(definition, dependencyInjector)
     * which leads to php warning "Cannot bind an instance to a static closure"
     *
     * @param Di $di
     * @codeCoverageIgnore
     */
    public static function fix(Di $di)
    {
        if ($_SERVER['PHWOOLCON_PHALCON_VERSION'] > '2010000') {
            $di->setInternalEventsManager($di->getShared('eventsManager'));
            Events::attach('di:beforeServiceResolve', function (Event $event) {
                /* @var Di $di */
                $di = $event->getSource();
                $data = $event->getData();
                $name = $data['name'];
                $parameters = $data['parameters'];
                if (!isset($di->_services[$name])) {
                    return false;
                }
                /* @var Di\Service $service */
                $service = $di->_services[$name];
                if (!$service->isShared()) {
                    return false;
                }
                if (!(($definition = $service->getDefinition()) instanceof Closure)) {
                    return false;
                }
                return $parameters ? call_user_func_array($definition, $parameters) : call_user_func($definition);
            });
        }
    }
}
