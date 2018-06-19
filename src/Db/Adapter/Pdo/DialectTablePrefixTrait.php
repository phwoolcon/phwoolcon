<?php

namespace Phwoolcon\Db\Adapter\Pdo;

/**
 * Trait DialectTablePrefixTrait
 * @package Phwoolcon\Db\Adapter\Pdo
 * @codeCoverageIgnore
 */
trait DialectTablePrefixTrait
{
    /**
     * @var TablePrefixTrait
     */
    protected $connection;

    public function select(array $definition)
    {
        if (isset($definition['tables']) && is_array($definition['tables'])) {
            $definition['tables'] = $this->prefixTables($definition['tables']);
        }
        if (isset($definition['columns'])) {
            $definition['columns'] = $this->prefixColumns($definition['columns']);
        }
        if (isset($definition['joins'])) {
            $definition['joins'] = $this->prefixJoins($definition['joins']);
        }
        if (isset($definition['where'])) {
            $definition['where'] = $this->prefixWhere($definition['where']);
        }
        return parent::select($definition);
    }

    protected function prefixColumns($columns)
    {
        foreach ($columns as &$column) {
            isset($column[1]) and $column[1] = $this->connection->prefixTable($column[1]);
        }
        unset($column);
        return $columns;
    }

    protected function prefixTables($tables)
    {
        $result = [];
        foreach ($tables as $table) {
            $result[] = $this->connection->prefixTable($table);
        }
        return $result;
    }

    protected function prefixJoins($joins)
    {
        foreach ($joins as &$join) {
            isset($join['source']) and $join['source'] = $this->connection->prefixTable($join['source']);
        }
        unset($join);
        return $joins;
    }

    protected function prefixWhere($where)
    {
        if (isset($where['left'])) {
            $where['left'] = $this->prefixWhere($where['left']);
        }
        if (isset($where['right'])) {
            $where['right'] = $this->prefixWhere($where['right']);
        }
        if (isset($where['domain'])) {
            $where['domain'] = $this->connection->prefixTable($where['domain']);
        }
        return $where;
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
