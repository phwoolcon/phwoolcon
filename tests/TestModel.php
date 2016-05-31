<?php
namespace Phwoolcon\Tests;

use Phalcon\Db\Column;
use Phwoolcon\Db;
use Phwoolcon\Model;

/**
 * Class TestModel
 * @package Phwoolcon\Tests
 *
 * @method string getKey()
 * @method $this setValue(mixed $value)
 */
class TestModel extends Model
{
    protected $_table = 'test_model';
    protected $_pk = 'key';

    protected function createTable()
    {
        $db = Db::connection();
        $db->createTable($this->_table, null, [
            'columns' => [
                new Column('key', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 32,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('value', [
                    'type' => Column::TYPE_TEXT,
                ]),
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
