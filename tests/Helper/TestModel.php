<?php
namespace Phwoolcon\Tests\Helper;

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;
use Phwoolcon\Cli\Command\Migrate;
use Phwoolcon\Db;
use Phwoolcon\Model;

/**
 * Class TestModel
 * @package Phwoolcon\Tests
 *
 * @method string getKey()
 * @method mixed getValue()
 * @method $this setValue(mixed $value)
 */
class TestModel extends Model
{
    protected $_table = 'test_model';
    protected $_pk = 'key';
    protected $_jsonFields = ['value'];
    protected $_readConnection = 'mysql';
    protected $_writeConnection = 'mysql';

    /**
     * @throws \Phalcon\Db\Exception
     */
    protected function createTable()
    {
        $migrate = new Migrate('migrate', $this->_dependencyInjector);
        $varChar = Column::TYPE_VARCHAR;
        $bigInt = Column::TYPE_BIGINTEGER;
        $text = Column::TYPE_TEXT;
        $migrate->createTableOn(Db::connection(), $this->_table, [
            'key'           => ['type' => $varChar, 'size' => 32, 'notNull' => true, 'primary' => true],
            'value'         => ['type' => $text],
            'default_value' => ['type' => $varChar, 'notNull' => true, 'default' => ''],
            'created_at'    => ['type' => $bigInt, 'size' => 20, 'unsigned' => true, 'notNull' => false],
            'updated_at'    => ['type' => $bigInt, 'size' => 20, 'unsigned' => true, 'notNull' => false],
        ]);
    }

    public function initialize()
    {
        parent::initialize();
        $db = Db::connection();
        $db->tableExists($this->_table) or $this->createTable();
        $db->delete($this->_table);
    }

    public function validation()
    {
        if ($_SERVER['PHWOOLCON_PHALCON_VERSION'] > 2010000) {
            $validator = new Validation();
            $validator->add('key', new StringLength([
                'min' => 3,
                'max' => 32,
            ]));
        } else {
            $validator = new \Phalcon\Mvc\Model\Validator\StringLength([
                'field' => 'key',
                'min' => 3,
                'max' => 32,
            ]);
        }
        $this->validate($validator);
        return parent::validation();
    }
}
