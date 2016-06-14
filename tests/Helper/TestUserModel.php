<?php
namespace Phwoolcon\Tests\Helper;

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phwoolcon\Db;
use Phwoolcon\Model\User;

class TestUserModel extends User
{

    protected function createTable()
    {
        $db = Db::connection();
        $db->createTable($this->_table, null, [
            'columns' => [
                new Column('id', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('username', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 20,
                    'notNull' => false,
                ]),
                new Column('email', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 255,
                    'notNull' => false,
                ]),
                new Column('mobile', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 20,
                    'notNull' => false,
                ]),
                new Column('password', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 160,
                    'notNull' => true,
                ]),
                new Column('confirmed', [
                    'type' => Column::TYPE_BOOLEAN,
                    'size' => 1,
                    'unsigned' => true,
                    'notNull' => true,
                    'default' => 0,
                ]),
                new Column('created_at', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => false,
                ]),
                new Column('updated_at', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => false,
                ]),
            ],
            'indexes' => [
                new Index('username', ['username'], 'UNIQUE'),
                new Index('email', ['email'], 'UNIQUE'),
                new Index('mobile', ['mobile'], 'UNIQUE'),
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
