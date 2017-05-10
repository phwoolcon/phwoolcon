<?php
namespace Phwoolcon\Tests\Integration\Cli;

use Exception;
use Phwoolcon\Config;
use Phwoolcon\Queue;
use Phwoolcon\Tests\Helper\CliTestCase;
use Phwoolcon\Tests\Helper\TestQueueWorker;

class QueueConsumeTest extends CliTestCase
{

    public function setUp()
    {
        parent::setUp();
        Config::set('queue.queues.default_queue.connection', 'beanstalkd');
        Config::set('queue.connections.beanstalkd.connect_timeout', 1);
        Queue::register($this->di);
        $this->clearQueue();
    }

    protected function clearQueue()
    {
        /* @var Queue\Adapter\Beanstalkd $connection */
        $connection = Queue::connection();
        $queue = $connection->getQueue(null);
        try {
            $pheanstalk = $connection->getConnection();
            while ($job = $pheanstalk->peekReady($queue)) {
                $pheanstalk->delete($job);
            }
        } catch (Exception $e) {
        }
    }

    public function testProduceAndConsume()
    {
        $data = ['foo' => 'bar'];
        $connection = Queue::connection();
        $connection->push([TestQueueWorker::class, 'staticWorker'], $data);

        TestQueueWorker::reset();
        $output = $this->runCommand('queue:consume', ['--ttl=0']);
        $this->assertEquals($data, TestQueueWorker::getJobData());
        $this->assertEmpty($output);
    }

    public function testMemoryLeak()
    {
        $memoryLimit = (int)(memory_get_usage() / 1024 / 1024) + 10;
        $data = ['foo' => 'bar'];
        $connection = Queue::connection();
        for ($i = 0; $i < 300; ++$i) {
            $connection->push([TestQueueWorker::class, 'memoryLeakWorker'], $data);
        }
        $output = $this->runCommand('queue:consume', ['--ttl=5', "--memory={$memoryLimit}"]);
        $this->assertStringEndsWith('Memory leak protection', trim($output));
        TestQueueWorker::reset();
        $this->clearQueue();
    }

    public function testException()
    {
        $data = ['foo' => 'bar'];
        $connection = Queue::connection();
        $connection->push([TestQueueWorker::class, 'staticFailureWorker'], $data);

        TestQueueWorker::reset();
        $output = $this->runCommand('queue:consume', ['--ttl=0']);
        $this->assertEquals($data, TestQueueWorker::getJobData());
        $this->assertStringEndsWith('Failure worker', trim($output));
        TestQueueWorker::reset();
        $this->clearQueue();
    }
}
