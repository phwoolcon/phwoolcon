<?php
namespace Phwoolcon\Queue\Adapter\DbQueue;

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phwoolcon\Db;
use Phwoolcon\Model;

/**
 * DB Queue Connection
 * @package Phwoolcon\Queue\Adapter\DbQueue
 *
 * @property $meta
 * @property $payload
 * @property $reserved_until
 * @property $status
 * @property $tries
 */
class Connection extends Model
{
    const STATUS_READY = 'ready';
    const STATUS_RESERVED = 'reserved';
    const STATUS_BURIED = 'buried';
    const STATUS_DELETED = 'deleted';

    protected $_jsonFields = ['meta'];

    protected $options;

    public function bury()
    {
        $this->status = static::STATUS_BURIED;
        $this->reserved_until = 0;
        $this->save();
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function createTable()
    {
        $this->getWriteConnection()->createTable($this->_table, null, [
            'columns' => [
                new Column('id', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('queue', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 255,
                    'notNull' => true,
                ]),
                new Column('payload', [
                    'type' => 'LONGTEXT',
                    'notNull' => false,
                ]),
                new Column('status', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 255,
                    'notNull' => true,
                ]),
                new Column('tries', [
                    'type' => Column::TYPE_INTEGER,
                    'size' => 2,
                    'unsigned' => true,
                    'notNull' => true,
                    'default' => '0',
                ]),
                new Column('reserved_until', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                ]),
                new Column('meta', [
                    'type' => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
                new Column('created_at', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                ]),
                new Column('updated_at', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                ]),
            ],
            'indexes' => [
                new Index('queue', ['queue', 'reserved_until']),
                new Index('status', ['status']),
            ],
            'options' => [
                'TABLE_COLLATION' => Db::getDefaultTableCharset(),
            ],
        ]);
    }

    public function kick($max)
    {
        /* @var static $item */
        foreach ($items = static::findSimple([
            'status' => static::STATUS_BURIED,
        ], [], 'id ASC', null, $max) as $item) {
            $item->release();
        }
        return count($items);
    }

    protected function onConstruct()
    {
    }

    public function push($queue, $payload, array $options = [])
    {
        $item = clone $this;
        isset($options['time_to_run']) or $options['time_to_run'] = fnGet($this->options, 'time_to_run', 60);
        $item->addData([
            'queue' => $queue,
            'payload' => $payload,
            'status' => 'ready',
            'tries' => 0,
            'reserved_until' => 0,
            'meta' => $options,
        ])->save();
        return $item->getId();
    }

    public function release()
    {
        $this->status = static::STATUS_READY;
        $this->reserved_until = 0;
        $this->save();
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function releaseTimeoutJobs($queue)
    {
        /* @var static $item */
        foreach (static::findSimple([
            'queue' => $queue,
            'reserved_until' => ['>=', time()],
            'status' => static::STATUS_RESERVED,
        ], [], 'id ASC') as $item) {
            $item->release();
        }
    }

    public function reserve($queue)
    {
        $this->releaseTimeoutJobs($queue);
        if ($item = static::findFirstSimple([
            'queue' => $queue,
            'status' => static::STATUS_READY,
        ], [], 'id ASC')) {
            $item->status = static::STATUS_RESERVED;
            ++$item->tries;
            $this->reserved_until = time() + fnGet($this->meta, 'time_to_run');
            $item->save();
            return $item;
        }
        return null;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
        $table = fnGet($options, 'table', 'queue_jobs');
        $this->_table = $table;
        $this->setSource($table);
        $this->getWriteConnection()->tableExists($table) or $this->createTable();
        parent::onConstruct();
    }

    public function softDelete()
    {
        $this->status = static::STATUS_DELETED;
        $this->reserved_until = 0;
        $this->save();
        return $this;
    }
}
