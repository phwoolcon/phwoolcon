<?php
namespace Phwoolcon\Queue;

use Phalcon\Db\Column;
use Phwoolcon\Config;
use Phwoolcon\DateTime;
use Phwoolcon\Db;

class FailedLoggerDb
{
    protected $table;
    protected $options = [
        'connection' => '',
        'table' => 'failed_jobs',
    ];

    public function __construct($options)
    {
        $this->options = $options;
        $this->table = $options['table'];
        $db = $this->getDb();
        $db->tableExists($this->table) or $this->createTable();
        Config::runningUnitTest() and $db->delete($this->table);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function createTable()
    {
        $this->getDb()->createTable($this->table, null, [
            'columns' => [
                new Column('id', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                    'primary' => true,
                    'autoIncrement' => true,
                ]),
                new Column('connection', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 255,
                    'notNull' => true,
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
                new Column('failed_at', [
                    'type' => Column::TYPE_TIMESTAMP,
                    'notNull' => true,
                    'default' => 'CURRENT_TIMESTAMP',
                ]),
            ],
            'options' => [
                'TABLE_COLLATION' => Db::getDefaultTableCharset(),
            ],
        ]);
    }

    protected function getDb()
    {
        return Db::connection($this->options['connection']);
    }

    /**
     * Log a failed job into storage.
     *
     * @param  string $connection
     * @param  string $queue
     * @param  string $payload
     * @return void
     */
    public function log($connection, $queue, $payload)
    {
        $failed_at = date(DateTime::MYSQL_DATETIME);
        $this->getDb()->insertAsDict($this->table, compact('connection', 'queue', 'payload', 'failed_at'));
    }
}
