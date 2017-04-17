<?php
namespace Phwoolcon\Util\Counter\Adapter;

use Phalcon\Db\Column;
use Phalcon\Db\Dialect;
use Phalcon\Db\RawValue;
use Phwoolcon\Db;
use Phwoolcon\Util\Counter\Adapter;

class Rds extends Adapter
{
    protected $table = 'counter';

    protected $selectSql;
    protected $updateCondition;
    /**
     * @var Dialect
     */
    protected $dialect;

    public function __construct($options)
    {
        parent::__construct($options);
        isset($options['table']) and $this->table = $options['table'];
        $db = Db::connection();
        if (!$db->tableExists($this->table)) {
            $this->createTable();
        }
        /* @var Dialect $dialect */
        $dialect = $this->dialect = $db->getDialect();
        $this->selectSql = $dialect->select([
            'tables' => [$this->table],
            'columns' => ['value'],
            'where' => $where = $dialect->escape('key') . ' = ?',
            'forUpdate' => true,
        ]);
        $this->updateCondition = $where;
    }

    protected function createTable()
    {
        $db = Db::connection();
        $db->createTable($this->table, null, [
            'columns' => [
                new Column('key', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 255,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('value', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => false,
                    'notNull' => true,
                ]),
            ],
            'options' => [
                'TABLE_COLLATION' => 'utf8_unicode_ci',
            ],
        ]);
    }

    public function increment($keyName, $value = 1)
    {
        $db = Db::connection();
        $db->begin();
        if (!$db->query($this->selectSql, [$keyName])->fetch()) {
            $db->insert($this->table, [
                'key' => $keyName,
                'value' => $value,
            ]);
            $result = $value;
        } else {
            $db->updateAsDict($this->table, [
                'value' => new RawValue($this->dialect->escape('value') . ' + ' . (int)$value),
            ], [
                'conditions' => $this->updateCondition,
                'bind' => [$keyName],
            ]);
            $result = $db->fetchColumn($this->selectSql, [$keyName]);
        }
        $db->commit();
        return $result;
    }

    public function decrement($keyName, $value = 1)
    {
        return $this->increment($keyName, -$value);
    }

    public function reset($keyName)
    {
        $db = Db::connection();
        $db->updateAsDict($this->table, [
            'value' => 0,
        ], [
            'conditions' => $this->updateCondition,
            'bind' => [$keyName],
        ]);
    }
}
