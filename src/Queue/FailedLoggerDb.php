<?php
namespace Phwoolcon\Queue;

use Phalcon\Db\Column;
use Phwoolcon\Config;
use Phwoolcon\DateTime;
use Phwoolcon\Db;

class FailedLoggerDb
{
    /**
     * @var \Phalcon\Db\Adapter\Pdo|Db\Adapter\Pdo\Mysql
     */
    protected $db;
    protected $table;
    protected $options = [
        'connection' => '',
        'table' => 'failed_jobs',
    ];

    public function __construct($options)
    {
        $this->options = $options;
        $this->table = $options['table'];
        $this->db = Db::connection($options['connection']);
        $this->db->tableExists($this->table) or $this->createTable();
        Config::runningUnitTest() and $this->db->delete($this->table);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function createTable()
    {
        $this->db->createTable($this->table, null, [
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
        $this->db->insertAsDict($this->table, compact('connection', 'queue', 'payload', 'failed_at'));
    }
}
