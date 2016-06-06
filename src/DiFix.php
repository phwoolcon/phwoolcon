<?php
namespace Phwoolcon;

use Closure;
use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Version;

class DiFix extends Di
{

    public static function register(Di $di)
    {
        // Fix over clever di service resolver:
        // let definition = \Closure::bind(definition, dependencyInjector)
        // which leads to php warning "Cannot bind an instance to a static closure"
        if (Version::getId() > '2010000') {
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
                // @codeCoverageIgnoreStart
                if (!$service->isShared()) {
                    return false;
                }
                // @codeCoverageIgnoreEnd
                if (!(($definition = $service->getDefinition()) instanceof Closure)) {
                    return false;
                }
                return $parameters ? call_user_func_array($definition, $parameters) : call_user_func($definition);
            });
        }
    }
}
