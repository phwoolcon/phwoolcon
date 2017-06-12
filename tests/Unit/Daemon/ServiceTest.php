<?php
namespace Phwoolcon\Tests\Unit\Daemon;

use Phwoolcon\Db;
use Phwoolcon\Log;
use Phwoolcon\Tests\Helper\TestService as Service;
use Phwoolcon\Tests\Helper\TestCase;
use Swoole\Client;
use Swoole\Process;

class ServiceTest extends TestCase
{
    /**
     * @var Service
     */
    protected $service;

    protected function request($request)
    {
        $runDir = $this->service->getRunDir();

        $port = include($runDir . 'service-port.php');

        $sockFile = $runDir . 'service-' . $port . '.sock';
        $client = new Client(SWOOLE_UNIX_STREAM);
        $client->set([
            'open_length_check' => true,
            'package_length_type' => 'N',
            'package_length_offset' => 0,
            'package_body_offset' => 4,
        ]);

        if (!@$client->connect($sockFile, 0, 20)) {
            return false;
        }

        $request = serialize($request);
        $client->send(pack('N', $length = strlen($request)));

        if ($length > 2097152) {
            foreach (str_split($request, 1048576) as $chunk) {
                $client->send($chunk);
            }
        } else {
            $client->send($request);
        }
        if ($rounds = $client->recv()) {
            $roundsLength = unpack('N', $rounds)[1];
            $rounds = substr($rounds, -$roundsLength);
            $response = '';
            for (; $rounds > 0; --$rounds) {
                $responseChunk = $client->recv();
                $chunkLength = unpack('N', $responseChunk)[1];
                $response .= substr($responseChunk, -$chunkLength);
            }
            $client->close();
            return unserialize($response);
        }
        return false;
    }

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
        $this->service->stop();
        $this->service->stop('old');
        parent::tearDown();
    }

    public function testChoosePort()
    {
        $service = $this->service;
        opcache_reset();
        $port = $service->choosePort();
        $this->assertEquals($port, $service->choosePort());

        // Swap port
        $service->choosePort(true);
        opcache_reset();
        $this->assertNotEquals($port, $service->choosePort());

        // Swap port
        $service->choosePort(true);
        opcache_reset();
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

        // Test request
        $request = [
            'request' => ['foo' => 'bar'],
            'cookies' => [],
            'server' => array_merge($_SERVER, ['REQUEST_URI' => '/test-controller-route', 'REQUEST_METHOD' => 'GET']),
            'files' => [],
        ];
        $response = $this->request($request);
        $this->assertArrayHasKey('headers', $response);
        $this->assertArrayHasKey('body', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('HTTP/1.1 200 OK', $response['headers']['status']);
        $this->assertEquals('Test Controller Route Content', $response['body']);

        // Test request for json api
        $request = [
            'request' => ['foo' => 'bar'],
            'cookies' => [],
            'server' => array_merge($_SERVER, ['REQUEST_URI' => '/api/test-json-api-data', 'REQUEST_METHOD' => 'GET']),
            'files' => [],
        ];
        $response = $this->request($request);
        $this->assertArrayHasKey('headers', $response);
        $this->assertArrayHasKey('body', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('HTTP/1.1 200 OK', $response['headers']['status']);
        $this->assertJson($response['body']);

        // Test request for large body
        $request = [
            'request' => ['key' => $value = str_repeat('ABC', 1e6)],
            'cookies' => [],
            'server' => array_merge($_SERVER, ['REQUEST_URI' => '/test-controller-input', 'REQUEST_METHOD' => 'GET']),
            'files' => [],
        ];
        $response = $this->request($request);
        $this->assertArrayHasKey('headers', $response);
        $this->assertArrayHasKey('body', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertEquals('HTTP/1.1 200 OK', $response['headers']['status']);
        $this->assertEquals($value, $response['body']);

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
