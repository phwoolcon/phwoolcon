<?php
namespace Phwoolcon\Tests\Helper;

use Exception;

class TestQueueWorker
{
    protected static $jobData;

    public function diSharedWorker($job, $data)
    {
        static::$jobData = $data;
    }

    public static function getJobData()
    {
        return static::$jobData;
    }

    public function objectWorker($job, $data)
    {
        static::$jobData = $data;
    }

    public static function reset()
    {
        static::$jobData = null;
    }

    public static function staticWorker($job, $data)
    {
        static::$jobData = $data;
    }

    public static function staticFailureWorker($job, $data)
    {
        static::$jobData = $data;
        throw new Exception;
    }
}
