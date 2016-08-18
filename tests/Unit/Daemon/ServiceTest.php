<?php
namespace Phwoolcon\Tests\Unit\Daemon;

use Phwoolcon\Db;
use Phwoolcon\Log;
use Phwoolcon\Tests\Helper\TestService as Service;
use Phwoolcon\Tests\Helper\TestCase;
use Swoole\Process;

class ServiceTest extends TestCase
{
    /**
     * @var Service
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        Service::register($this->di);
        $this->service = $this->di->getShared('service');
        $this->service->setTestCase($this);
    }

    public function tearDown()
    {
        $this->appendRemoteCoverage();
        Process::wait();
        parent::tearDown();
    }

    public function testChoosePort()
    {
        $service = $this->service;
        $port = $service->choosePort();
        $this->assertEquals($port, $service->choosePort());

        // Swap port
        $service->choosePort(true);
        $this->assertNotEquals($port, $service->choosePort());

        // Swap port
        $service->choosePort(true);
        $this->assertEquals($port, $service->choosePort());
    }

    public function testStartAndStop()
    {
        $service = $this->service;

        // Service not started, should be error 2 No such file or directory, or 111 Connection refused
        $service->showStatus(null, false, $error);
        $this->assertContains(fnGet($error, 'err'), [2, 111], fnGet($error, 'message'));

        // Should be able to dry start
        $this->assertTrue($service->start(true));

        // Should be able to start
        $serverProcess = $service->startIsolated();

        // Should return running status
        $status = $service->showStatus(null, false, $error);
        $this->assertFalse($error);
        $this->assertStringStartsWith('Service is running. PID: ' . $serverProcess->pid, $status);

        // Should be able to stop
        $service->stop();

        // Service stopped, should be error 2 No such file or directory, or 111 Connection refused
        $service->showStatus(null, false, $error);
        $this->assertContains(fnGet($error, 'err'), [2, 111], fnGet($error, 'message'));
    }

    public function testReceive()
    {
        $service = $this->service;
        // Should be able to start
        $serverProcess = $service->startIsolated();

        // Should return running status
        $status = $service->showStatus(null, false, $error);
        $this->assertFalse($error);
        $this->assertStringStartsWith('Service is running. PID: ' . $serverProcess->pid, $status);

        // Should be able to stop
        $service->stop();

        // Service stopped, should be error 2 No such file or directory, or 111 Connection refused
        $service->showStatus(null, false, $error);
        $this->assertContains(fnGet($error, 'err'), [2, 111], fnGet($error, 'message'));
    }

    public function testReload()
    {
        $service = $this->service;

        // Should be able to start
        $serverProcess = $service->startIsolated();

        // Should return running status
        $status = $service->showStatus(null, false, $error);
        $this->assertFalse($error);
        $this->assertStringStartsWith('Service is running. PID: ' . $serverProcess->pid, $status);

        // Get current port
        $oldPort = $service->choosePort();

        // Port should be shifted
        $service->shift();
        $this->assertNotEquals($oldPort, $service->choosePort());

        /*
         * TODO The old instance should be stopped after new instance is started
         *      But I am unable to start two instances due to swoole status detection
         *      It may be implemented in the future if swoole fixed this
         */
        // Should be able to stop old instance
        $service->stop('old');

        // Should be able to start new instance
        $substituteServerProcess = $service->startIsolated();

        // Should return running status
        $status = $service->showStatus(null, false, $error);
        $this->assertFalse($error);
        $this->assertStringStartsWith('Service is running. PID: ' . $substituteServerProcess->pid, $status);

        // Should be able to stop
        $service->stop();

        // Service stopped, should be error 2 No such file or directory, or 111 Connection refused
        $service->showStatus(null, false, $error);
        $this->assertContains(fnGet($error, 'err'), [2, 111], fnGet($error, 'message'));
    }
}
