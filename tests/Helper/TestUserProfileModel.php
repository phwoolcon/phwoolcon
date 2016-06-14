<?php
namespace Phwoolcon\Tests\Helper;

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phwoolcon\Db;
use Phwoolcon\Model\UserProfile;

class TestUserProfileModel extends UserProfile
{

    protected function createTable()
    {
        $db = Db::connection();
        $db->createTable($this->_table, null, [
            'columns' => [
                new Column('user_id', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('real_name', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 32,
                    'notNull' => false,
                ]),
                new Column('avatar', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 255,
                    'notNull' => true,
                    'default' => '',
                ]),
                new Column('remember_token', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 52,
                    'notNull' => false,
                ]),
                new Column('extra_data', [
                    'type' => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
            ],
            'references' => [
                new Reference('user_profile_users_user_id', [
                    'referencedTable' => 'users',
                    'columns' => ['user_id'],
                    'referencedColumns' => ['id'],
                    'onDelete' => 'CASCADE',
                    'onUpdate' => 'CASCADE',
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
