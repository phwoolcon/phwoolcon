<?php
namespace Phwoolcon\Queue\Adapter\DbQueue;

use Phwoolcon\Queue\Adapter\JobInterface;
use Phwoolcon\Queue\Adapter\JobTrait;

/**
 * DB Queue Job
 * @package Phwoolcon\Queue\Adapter\DbQueue
 *
 * @property Connection $rawJob
 */
class Job implements JobInterface
{
    use JobTrait;

    protected function _delete()
    {
        $this->rawJob->softDelete();
    }

    protected function _release($delay = 0)
    {
        $this->rawJob->release();
    }

    public function attempts()
    {
        return (int)$this->rawJob->tries;
    }

    public function bury()
    {
        $this->rawJob->bury();
    }

    public function getJobId()
    {
        return $this->rawJob->getId();
    }

    public function getRawBody()
    {
        return $this->rawJob->payload;
    }
}
