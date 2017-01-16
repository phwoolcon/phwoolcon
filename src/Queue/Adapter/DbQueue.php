<?php
namespace Phwoolcon\Queue\Adapter;

use Phwoolcon\Queue\Adapter\DbQueue\Connection;
use Phwoolcon\Queue\Adapter\DbQueue\Job;
use Phwoolcon\Queue\AdapterInterface;
use Phwoolcon\Queue\AdapterTrait;

/**
 * Queue adapter: DbQueue
 * @package Phwoolcon\Queue\Adapter
 *
 * @property Connection $connection
 */
class DbQueue implements AdapterInterface
{
    use AdapterTrait;

    protected function connect(array $options)
    {
        $this->connection = new Connection();
        $this->connection->setOptions($options);
    }

    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);

        if (($job = $this->connection->reserve($queue)) instanceof Connection) {
            return new Job($this, $job, $queue);
        }
        return null;
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $payload = (string)$payload;
        $queue = $this->getQueue($queue);
        return $this->connection->push($queue, $payload, $options);
    }
}
