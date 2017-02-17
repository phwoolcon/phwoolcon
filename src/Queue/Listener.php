<?php
namespace Phwoolcon\Queue;

use Throwable;
use Phwoolcon\Queue;
use Phwoolcon\Queue\Adapter\JobInterface;
use Phwoolcon\Queue\Adapter\JobTrait;
use Phwoolcon\Queue\Listener\Result;

class Listener
{

    /**
     * Log a failed job into storage.
     *
     * @param  JobInterface|JobTrait $job
     */
    protected function fail($job)
    {
        Queue::getFailLogger()->log($job->getQueue()->getConnectionName(), $job->getQueueName(), $job->getRawBody());
        $job->delete();
    }

    /**
     * Listen to the given queue.
     *
     * @param  string $connectionName
     * @param  string $queue
     * @param  int    $delay
     * @param  int    $sleep
     * @param  int    $maxTries
     * @return Result
     */
    public function pop($connectionName, $queue = null, $delay = 0, $sleep = 3, $maxTries = 0)
    {
        $connection = Queue::connection($connectionName);

        if ($job = $connection->pop($queue)) {
            return $this->process($job, $maxTries, $delay);
        }
        // Sleep the worker for the specified number of seconds, if no jobs
        sleep($sleep);
        return Result::success(null);
    }

    /**
     * Process a given job from the queue.
     *
     * @param  JobInterface|JobTrait $job
     * @param  int                   $maxTries
     * @param  int                   $delay
     * @return Result
     *
     * @throws \Throwable
     */
    public function process(JobInterface $job, $maxTries = 0, $delay = 0)
    {
        if ($maxTries > 0 && $job->attempts() > $maxTries) {
            $this->fail($job);
            return Result::failed($job);
        }

        try {
            $job->fire();
            return Result::success($job);
        } catch (\Exception $e) {
            // If we catch an exception, we will attempt to release the job back onto
            // the queue so it is not lost. This will let is be retried at a later
            // time by another listener (or the same one). We will do that here.
            if (!$job->isDeleted()) {
                $job->release($delay);
            }
            throw $e;
        } // @codeCoverageIgnoreStart
        catch (Throwable $e) {
            if (!$job->isDeleted()) {
                $job->release($delay);
            }
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }
}
