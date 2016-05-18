<?php
namespace Phwoolcon\Queue\Adapter;

use Phwoolcon\Queue\AdapterTrait;

trait JobTrait
{

    /**
     * The queue instance.
     *
     * @var AdapterTrait
     */
    protected $queue;

    /**
     * The name of the queue the job belongs to.
     *
     * @var string
     */
    protected $queueName;
    /**
     * The raw job instance.
     */
    protected $rawJob;

    public function __construct($queue, $rawJob, $queueName)
    {
        $this->queue = $queue;
        $this->rawJob = $rawJob;
        $this->queueName = $queueName;
    }
}
