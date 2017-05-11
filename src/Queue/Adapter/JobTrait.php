<?php
namespace Phwoolcon\Queue\Adapter;

use Phwoolcon\Queue\AdapterInterface;
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
     * The queue connection
     */
    protected $connection;

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

    /**
     * Indicates if the job has been deleted.
     *
     * @var bool
     */
    protected $deleted = false;

    /**
     * Indicates if the job has been released.
     *
     * @var bool
     */
    protected $released = false;

    /**
     * JobTrait constructor.
     * @param AdapterInterface|AdapterTrait $queue
     * @param                               $rawJob
     * @param string                        $queueName
     */
    public function __construct($queue, $rawJob, $queueName)
    {
        $this->queue = $queue;
        $this->connection = $queue->getConnection();
        $this->rawJob = $rawJob;
        $this->queueName = $queueName;
    }

    abstract protected function _delete();

    abstract protected function _release($delay = 0);

    public function delete()
    {
        $this->_delete();
        $this->deleted = true;
    }

    public function fire()
    {
        // @codeCoverageIgnoreStart
        if ($worker = $this->queue->getPredefinedWorker()) {
            $data = $this->getRawBody();
        } //@codeCoverageIgnoreEnd
        else {
            $payload = json_decode($this->getRawBody(), true);
            $worker = $payload['job'];
            $data = $payload['data'];
        }
        if (is_string($worker)) {
            if (strpos($worker, $separator = '::')) {
                $worker = explode($separator, $worker, 2);
            } elseif (strpos($worker, $separator = '@')) {
                $worker = explode($separator, $worker, 2);
                $worker[0] = $this->queue->getDi()->getShared($worker[0]);
            } elseif (strpos($worker, $separator = '->')) {
                $worker = explode($separator, $worker, 2);
                $worker[0] = new $worker[0];
            }
        }
        call_user_func($worker, $this, $data);
        $this->delete();
    }

    public function getName()
    {
        return json_decode($this->getRawBody(), true)['job'];
    }

    /**
     * @return AdapterInterface|AdapterTrait
     * @codeCoverageIgnore
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    abstract public function getRawBody();

    /**
     * @codeCoverageIgnore
     */
    public function getRawJob()
    {
        return $this->rawJob;
    }

    /**
     * Determine if the job has been deleted.
     *
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    public function release($delay = 0)
    {
        $this->_release($delay);
        $this->released = true;
    }
}
