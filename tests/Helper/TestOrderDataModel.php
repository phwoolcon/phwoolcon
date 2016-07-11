<?php
namespace Phwoolcon\Tests\Helper;

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phwoolcon\Db;
use Phwoolcon\Model\OrderData;

class TestOrderDataModel extends OrderData
{

    protected function createTable()
    {
        $db = Db::connection();
        $db->createTable($this->_table, null, [
            'columns' => [
                new Column('order_id', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 50,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('request_data', [
                    'type' => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
                new Column('data', [
                    'type' => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
                new Column('status_history', [
                    'type' => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
            ],
            'options' => [
                'TABLE_COLLATION' => Db::getDefaultTableCharset(),
            ],
        ]);
    }

    public function initialize()
    {
        parent::initialize();
        $db = Db::connection();
        $db->tableExists($this->_table) or $this->createTable();
        $db->delete($this->_table);
    }
}
