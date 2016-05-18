<?php
namespace Phwoolcon\Queue;

use Phwoolcon\Queue\Adapter\JobInterface;
use Phwoolcon\Queue\Adapter\JobTrait;

interface AdapterInterface
{

    /**
     * Pop the next job off of the queue.
     *
     * @param  string $queue
     * @return JobInterface|JobTrait|null
     */
    public function pop($queue = null);

    /**
     * Push a new job onto the queue.
     *
     * @param  string $worker
     * @param  mixed  $data
     * @param  string $queue
     * @param  array  $options
     * @return mixed
     */
    public function push($worker, $data = '', $queue = null, array $options = []);

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string $payload
     * @param  string $queue
     * @param  array  $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = []);
}
