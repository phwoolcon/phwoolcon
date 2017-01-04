<?php
namespace Phwoolcon\Tests\Helper;

use Exception;

class TestQueueWorker
{
    protected static $jobData;
    protected static $memoryLeak = [];

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
        static::$memoryLeak = [];
    }

    public static function staticWorker($job, $data)
    {
        static::$jobData = $data;
    }

    public static function staticFailureWorker($job, $data)
    {
        static::$jobData = $data;
        throw new Exception('Failure worker');
    }

    public static function memoryLeakWorker($job, $data)
    {
        for ($i = 0; $i < 1000; ++$i) {
            static::$memoryLeak[] = $data;
        }
    }
}
