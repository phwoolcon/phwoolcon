<?php
namespace Phwoolcon\Queue\Adapter\Beanstalkd;

use Pheanstalk\Pheanstalk;
use Pheanstalk\Job as PheanstalkJob;
use Phwoolcon\Queue\Adapter\Beanstalkd;
use Phwoolcon\Queue\Adapter\JobInterface;
use Phwoolcon\Queue\Adapter\JobTrait;

/**
 * Class Job
 * @package Phwoolcon\Queue\Adapter\Beanstalkd
 *
 * @property Pheanstalk    $connection
 * @property Beanstalkd    $queue
 * @property PheanstalkJob $rawJob
 * @method  PheanstalkJob getRawJob()
 */
class Job implements JobInterface
{
    use JobTrait;

    protected function _delete()
    {
        $this->connection->delete($this->rawJob);
    }

    protected function _release($delay = 0)
    {
        $priority = Pheanstalk::DEFAULT_PRIORITY;
        $this->connection->release($this->rawJob, $priority, $delay);
    }

    public function attempts()
    {
        $stats = $this->connection->statsJob($this->rawJob);
        return (int)$stats->reserves;
    }

    /**
     * Bury the job in the queue.
     *
     * @return void
     */
    public function bury()
    {
        $this->connection->bury($this->rawJob);
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return $this->rawJob->getId();
    }

    public function getRawBody()
    {
        return $this->rawJob->getData();
    }
}
