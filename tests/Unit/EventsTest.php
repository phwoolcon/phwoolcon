<?php
namespace Phwoolcon\Tests\Unit;

use Phalcon\Events\Event;
use Phwoolcon\Events;
use Phwoolcon\Tests\Helper\TestCase;

class EventsTest extends TestCase
{
    protected $eventChangeValue = false;

    public function setUp()
    {
        parent::setUp();
    }

    public function testFireAndCatchEvent()
    {
        Events::attach($eventType = 'test:fireAndCatchEvent', function (Event $event) {
            /* @var static $obj */
            $obj = $event->getSource();
            $obj->eventChangeValue = true;
        });
        Events::fire($eventType, $this);
        $this->assertTrue($this->eventChangeValue, 'Event not caught');
    }

    public function testDetachEvent()
    {
        Events::detachAll($eventType = 'test:fireAndCatchEvent');
        Events::attach($eventType, $handler = function (Event $event) {
            /* @var static $obj */
            $obj = $event->getSource();
            $obj->eventChangeValue = true;
        });
        $this->eventChangeValue = false;
        Events::detach($eventType, $handler);
        Events::fire($eventType, $this);
        $this->assertFalse($this->eventChangeValue, 'Event not detached');
    }
}
