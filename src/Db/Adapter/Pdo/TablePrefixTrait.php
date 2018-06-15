<?php

namespace Phwoolcon\Db\Adapter\Pdo;

use Phalcon\Db\ColumnInterface;
use Phalcon\Db\IndexInterface;
use Phalcon\Db\ReferenceInterface;

trait TablePrefixTrait
{
    protected $tablePrefix = '';

    public function __construct(array $descriptor)
    {
        isset($descriptor['table_prefix']) and $this->tablePrefix = $descriptor['table_prefix'];
        parent::__construct($descriptor);
    }

    public function addColumn($tableName, $schemaName, ColumnInterface $column)
    {
        return parent::addColumn($this->tablePrefix . $tableName, $schemaName, $column);
    }

    public function addForeignKey($tableName, $schemaName, ReferenceInterface $reference)
    {
        return parent::addForeignKey($this->tablePrefix . $tableName, $schemaName, $reference);
    }

    public function addIndex($tableName, $schemaName, IndexInterface $index)
    {
        return parent::addIndex($this->tablePrefix . $tableName, $schemaName, $index);
    }

    public function addPrimaryKey($tableName, $schemaName, IndexInterface $index)
    {
        return parent::addPrimaryKey($this->tablePrefix . $tableName, $schemaName, $index);
    }

    public function createTable($tableName, $schemaName, array $definition)
    {
        return parent::createTable($this->tablePrefix . $tableName, $schemaName, $definition);
    }

    public function delete($table, $whereCondition = null, $placeholders = null, $dataTypes = null)
    {
        return parent::delete($this->tablePrefix . $table, $whereCondition, $placeholders, $dataTypes);
    }

    public function describeColumns($table, $schema = null)
    {
        return parent::describeColumns($this->tablePrefix . $table, $schema);
    }

    public function describeIndexes($table, $schema = null)
    {
        return parent::describeIndexes($this->tablePrefix . $table, $schema);
    }

    public function describeReferences($table, $schema = null)
    {
        return parent::describeReferences($this->tablePrefix . $table, $schema);
    }

    public function dropColumn($tableName, $schemaName, $columnName)
    {
        return parent::dropColumn($this->tablePrefix . $tableName, $schemaName, $columnName);
    }

    public function dropForeignKey($tableName, $schemaName, $referenceName)
    {
        return parent::dropForeignKey($this->tablePrefix . $tableName, $schemaName, $referenceName);
    }

    public function dropIndex($tableName, $schemaName, $indexName)
    {
        return parent::dropIndex($this->tablePrefix . $tableName, $schemaName, $indexName);
    }

    public function dropPrimaryKey($tableName, $schemaName)
    {
        return parent::dropPrimaryKey($this->tablePrefix . $tableName, $schemaName);
    }

    public function dropTable($tableName, $schemaName = null, $ifExists = true)
    {
        return parent::dropTable($this->tablePrefix . $tableName, $schemaName, $ifExists);
    }

    public function insert($table, array $values, $fields = null, $dataTypes = null)
    {
        return parent::insert($this->tablePrefix . $table, $values, $fields, $dataTypes);
    }

    public function insertAsDict($table, $data, $dataTypes = null)
    {
        return parent::insertAsDict($this->tablePrefix . $table, $data, $dataTypes);
    }

    public function listTables($schemaName = null)
    {
        $result = parent::listTables($schemaName);
        if ($this->tablePrefix && $result) {
            $prefixLength = strlen($this->tablePrefix);
            $newResult = [];
            foreach ($result as $k => $table) {
                if (substr($table, 0, $prefixLength) == $this->tablePrefix) {
                    $newResult[$k] = substr($table, $prefixLength);
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
        return parent::modifyColumn($this->tablePrefix . $tableName, $schemaName, $column, $currentColumn);
    }

    public function tableExists($tableName, $schemaName = null)
    {
        return parent::tableExists($this->tablePrefix . $tableName, $schemaName);
    }

    public function tableOptions($tableName, $schemaName = null)
    {
        return parent::tableOptions($this->tablePrefix . $tableName, $schemaName);
    }

    public function update($table, $fields, $values, $whereCondition = null, $dataTypes = null)
    {
        return parent::update($this->tablePrefix . $table, $fields, $values, $whereCondition, $dataTypes);
    }

    public function updateAsDict($table, $data, $whereCondition = null, $dataTypes = null)
    {
        return parent::updateAsDict($this->tablePrefix . $table, $data, $whereCondition, $dataTypes);
    }
}
