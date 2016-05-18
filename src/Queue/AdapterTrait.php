<?php
namespace Phwoolcon\Queue;

trait AdapterTrait
{
    protected $connection;
    protected $defaultQueue;
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
        $this->defaultQueue = $options['default'];
        $this->connect($options);
    }

    abstract protected function connect(array $options);

    /**
     * Create a payload string from the given worker and data.
     *
     * @param  array|callable $worker
     * @param  mixed          $data
     * @return string
     */
    protected function createPayload($worker, $data = '')
    {
        return serialize(['worker' => $worker, 'data' => $data]);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get the queue or return the default.
     *
     * @param  string|null $queue
     * @return string
     */
    public function getQueue($queue)
    {
        return $queue ?: $this->defaultQueue;
    }

    public function push($worker, $data = '', $queue = null, array $options = [])
    {
        return $this->pushRaw($this->createPayload($worker, $data), $queue, $options);
    }
}
