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
 * @property Beanstalkd    $queue
 * @property PheanstalkJob $rawJob
 */
class Job implements JobInterface
{
    use JobTrait;
}
