<?php
namespace Phwoolcon\Queue\Adapter;

use Pheanstalk\Pheanstalk;
use Pheanstalk\Job as PheanstalkJob;
use Phwoolcon\Queue\Adapter\Beanstalkd\Job;
use Phwoolcon\Queue\AdapterInterface;
use Phwoolcon\Queue\AdapterTrait;

/**
 * Class Beanstalkd
 * @package Phwoolcon\Queue\Adapter
 *
 * @property Pheanstalk $connection
 * @method Pheanstalk getConnection()
 */
class Beanstalkd implements AdapterInterface
{
    use AdapterTrait;
    protected $readTimeout = null;

    protected function connect(array $options)
    {
        // @codeCoverageIgnoreStart
        if ($this->connection) {
            return;
        }
        // @codeCoverageIgnoreEnd
        $this->connection = new Pheanstalk(
            $options['host'],
            $options['port'],
            $options['connect_timeout'],
            $options['persistence']
        );
        isset($options['read_timeout']) and $this->readTimeout = $options['read_timeout'];
    }

    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);

        if (($job = $this->connection->watchOnly($queue)->reserve($this->readTimeout)) instanceof PheanstalkJob) {
            return new Job($this, $job, $queue);
        }
        return null;
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $payload = (string)$payload;
        $priority = isset($options['priority']) ? $options['priority'] : Pheanstalk::DEFAULT_PRIORITY;
        $delay = isset($options['delay']) ? $options['delay'] : Pheanstalk::DEFAULT_DELAY;
        $timeToRun = isset($options['ttr']) ? $options['ttr'] : Pheanstalk::DEFAULT_TTR;
        return $this->connection->useTube($this->getQueue($queue))
            ->put($payload, $priority, $delay, $timeToRun);
    }
}
