<?php

namespace Phwoolcon\Db\Adapter\Pdo;

use Phalcon\Db\ColumnInterface;
use Phalcon\Db\IndexInterface;
use Phalcon\Db\ReferenceInterface;

/**
 * Trait TablePrefixTrait
 * @package Phwoolcon\Db\Adapter\Pdo
 * @codeCoverageIgnore
 */
trait TablePrefixTrait
{
    protected $tablePrefix = '';
    protected $tablePrefixLength = 0;

    public function __construct(array $descriptor)
    {
        if (isset($descriptor['table_prefix'])) {
            $this->tablePrefix = $descriptor['table_prefix'];
            $this->tablePrefixLength = strlen($this->tablePrefix);
        }
        parent::__construct($descriptor);
        $this->_dialect instanceof DialectTablePrefixInterface and $this->_dialect->setConnection($this);
    }

    public function prefixTable($table)
    {
        if ($this->tablePrefixLength && substr($table, 0, $this->tablePrefixLength) !== $this->tablePrefix) {
            return $this->tablePrefix . $table;
        }
        return $table;
    }

    public function addColumn($tableName, $schemaName, ColumnInterface $column)
    {
        return parent::addColumn($this->prefixTable($tableName), $schemaName, $column);
    }

    public function addForeignKey($tableName, $schemaName, ReferenceInterface $reference)
    {
        return parent::addForeignKey($this->prefixTable($tableName), $schemaName, $reference);
    }

    public function addIndex($tableName, $schemaName, IndexInterface $index)
    {
        return parent::addIndex($this->prefixTable($tableName), $schemaName, $index);
    }

    public function addPrimaryKey($tableName, $schemaName, IndexInterface $index)
    {
        return parent::addPrimaryKey($this->prefixTable($tableName), $schemaName, $index);
    }

    public function createTable($tableName, $schemaName, array $definition)
    {
        return parent::createTable($this->prefixTable($tableName), $schemaName, $definition);
    }

    public function delete($table, $whereCondition = null, $placeholders = null, $dataTypes = null)
    {
        return parent::delete($this->prefixTable($table), $whereCondition, $placeholders, $dataTypes);
    }

    public function describeColumns($table, $schema = null)
    {
        return parent::describeColumns($this->prefixTable($table), $schema);
    }

    public function describeIndexes($table, $schema = null)
    {
        return parent::describeIndexes($this->prefixTable($table), $schema);
    }

    public function describeReferences($table, $schema = null)
    {
        return parent::describeReferences($this->prefixTable($table), $schema);
    }

    public function dropColumn($tableName, $schemaName, $columnName)
    {
        return parent::dropColumn($this->prefixTable($tableName), $schemaName, $columnName);
    }

    public function dropForeignKey($tableName, $schemaName, $referenceName)
    {
        return parent::dropForeignKey($this->prefixTable($tableName), $schemaName, $referenceName);
    }

    public function dropIndex($tableName, $schemaName, $indexName)
    {
        return parent::dropIndex($this->prefixTable($tableName), $schemaName, $indexName);
    }

    public function dropPrimaryKey($tableName, $schemaName)
    {
        return parent::dropPrimaryKey($this->prefixTable($tableName), $schemaName);
    }

    public function dropTable($tableName, $schemaName = null, $ifExists = true)
    {
        return parent::dropTable($this->prefixTable($tableName), $schemaName, $ifExists);
    }

    public function insert($table, array $values, $fields = null, $dataTypes = null)
    {
        return parent::insert($this->prefixTable($table), $values, $fields, $dataTypes);
    }

    public function insertAsDict($table, $data, $dataTypes = null)
    {
        return parent::insertAsDict($this->prefixTable($table), $data, $dataTypes);
    }

    public function listTables($schemaName = null)
    {
        $result = parent::listTables($schemaName);
        if ($this->tablePrefixLength && $result) {
            $newResult = [];
            foreach ($result as $k => $table) {
                if (substr($table, 0, $this->tablePrefixLength) === $this->tablePrefix) {
                    $newResult[$k] = substr($table, $this->tablePrefixLength);
                }
            }
            return $newResult;
        }
        return $result;
    }

    public function modifyColumn(
        $tableName,
        $schemaName,
        ColumnInterface $column,
        ColumnInterface $currentColumn = null
    ) {
        return parent::modifyColumn($this->prefixTable($tableName), $schemaName, $column, $currentColumn);
    }

    public function tableExists($tableName, $schemaName = null)
    {
        return parent::tableExists($this->prefixTable($tableName), $schemaName);
    }

    public function tableOptions($tableName, $schemaName = null)
    {
        return parent::tableOptions($this->prefixTable($tableName), $schemaName);
    }

    public function update($table, $fields, $values, $whereCondition = null, $dataTypes = null)
    {
        return parent::update($this->prefixTable($table), $fields, $values, $whereCondition, $dataTypes);
    }

    public function updateAsDict($table, $data, $whereCondition = null, $dataTypes = null)
    {
        return parent::updateAsDict($this->prefixTable($table), $data, $whereCondition, $dataTypes);
    }
}
