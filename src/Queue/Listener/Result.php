<?php
namespace Phwoolcon\Queue\Listener;

use Phwoolcon\Queue\Adapter\JobInterface;

class Result
{
    const STATUS_SUCCESS = 1;
    const STATUS_FAILED = 0;

    /**
     * @var JobInterface|null
     */
    protected $job;
    protected $status = false;

    public function __construct(JobInterface $job = null, $status = self::STATUS_SUCCESS)
    {
        $this->job = $job;
        $this->status = $status;
    }

    public static function failed(JobInterface $job = null)
    {
        return new static($job, static::STATUS_FAILED);
    }

    public function getJob()
    {
        return $this->job;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function success(JobInterface $job = null)
    {
        return new static($job, static::STATUS_SUCCESS);
    }
}
