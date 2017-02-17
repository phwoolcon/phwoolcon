<?php
namespace Phwoolcon\Tests\Integration;

use Exception;
use Phwoolcon\Config;
use Phwoolcon\Queue;
use Phwoolcon\Queue\Listener;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Tests\Helper\TestQueueWorker;

class QueueTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Queue::register($this->di);
    }

    protected function realTestQueuePushAndFire($driver)
    {
        Config::set('queue.queues.default_queue.connection', $driver);
        Queue::register($this->di);
        $queue = Queue::connection();
        $workerClass = TestQueueWorker::class;
        $data = [
            'foo' => 'bar',
        ];

        TestQueueWorker::reset();
        $queue->push($jobName = "{$workerClass}::staticWorker", $data);
        $job = $queue->pop();
        $this->assertEquals($jobName, $job->getName());
        $this->assertNull(TestQueueWorker::getJobData());
        $job->fire();
        $this->assertEquals($data, TestQueueWorker::getJobData(), 'Unable to fire static queue worker');

        TestQueueWorker::reset();
        $queue->push("{$workerClass}->objectWorker", $data);
        $job = $queue->pop();
        $this->assertNull(TestQueueWorker::getJobData());
        $job->fire();
        $this->assertEquals($data, TestQueueWorker::getJobData(), 'Unable to fire object queue worker');

        TestQueueWorker::reset();
        $queue->push("{$workerClass}@diSharedWorker", $data);
        $job = $queue->pop();
        $this->assertNull(TestQueueWorker::getJobData());
        $job->fire();
        $this->assertEquals($data, TestQueueWorker::getJobData(), 'Unable to fire di shared queue worker');
    }

    public function testBeanstalkdPushAndFire()
    {
        $this->realTestQueuePushAndFire('beanstalkd');
    }

    public function testDbQueuePushAndFire()
    {
        $this->realTestQueuePushAndFire('db');
    }

    public function testBeanstalkdQueueJobsOperation()
    {
        $this->realTestQueueJobsOperation('beanstalkd');
    }

    public function testDbQueueJobsOperation()
    {
        $this->realTestQueueJobsOperation('db');
    }

    public function realTestQueueJobsOperation($driver)
    {
        Config::set('queue.queues.default_queue.connection', $driver);
        Queue::register($this->di);
        /* @var Queue\Adapter\Beanstalkd $queue */
        $queue = Queue::connection();
        $data = 'Test raw data';

        // Push
        $jobId = $queue->pushRaw($data);
        $this->assertTrue(is_numeric($jobId));

        $attempts = 0;

        // Pop
        /* @var Queue\Adapter\Beanstalkd\Job $job */
        $job = $queue->pop();
        ++$attempts;
        $this->assertEquals($data, $job->getRawBody());
        $this->assertEquals($jobId, $job->getJobId());

        // Release
        $job->release();

        // Bury
        $job = $queue->pop();
        ++$attempts;
        $this->assertEquals($data, $job->getRawBody());
        $this->assertEquals($jobId, $job->getJobId());
        $job->bury();

        // Pop empty
        $job = $queue->pop();
        $this->assertNull($job);

        // Kick
        $this->assertTrue(is_numeric($queue->getConnection()->kick(1)));

        // Attempts
        $job = $queue->pop();
        ++$attempts;
        $this->assertEquals($jobId, $job->getJobId());
        $this->assertEquals($attempts, $job->attempts());

        // Delete
        $this->assertFalse($job->isDeleted());
        $job->delete();
        $this->assertTrue($job->isDeleted());
    }

    public function testListener()
    {
        Queue::register($this->di);
        $queue = Queue::connection();
        $data = [
            'test' => 'listener',
        ];

        TestQueueWorker::reset();
        $queue->push([TestQueueWorker::class, 'staticWorker'], $data);

        // Listen and fire job
        $listener = new Listener();
        $listener->pop('', null, 0, 0, 1);
        $this->assertEquals($data, TestQueueWorker::getJobData(), 'Unable to fire queue listener');

        // Pop nothing from a empty queue
        $result = $listener->pop('', null, 0, 0, 1);
        $this->assertNull($result->getJob());
        $this->assertEquals($result::STATUS_SUCCESS, $result->getStatus());
    }

    public function testFailedListener()
    {
        Queue::register($this->di);
        $queue = Queue::connection();
        $workerClass = TestQueueWorker::class;
        $data = [
            'test' => 'listener',
        ];

        TestQueueWorker::reset();
        $queue->push("{$workerClass}::staticFailureWorker", $data);

        // Failure
        $listener = new Listener();
        $e = null;
        try {
            $listener->pop('', null, 0, 0, 1);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf(Exception::class, $e);

        // Log failure job
        $result = $listener->pop('', null, 0, 0, 1);
        $this->assertEquals($result::STATUS_FAILED, $result->getStatus());
    }
}
