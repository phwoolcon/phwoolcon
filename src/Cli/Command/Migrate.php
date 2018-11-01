<?php

namespace Phwoolcon\Cli\Command;

use Exception;
use Phalcon\Db\Adapter;
use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phwoolcon\Cli\Command;
use Phwoolcon\Config;
use Phwoolcon\Db;
use Phwoolcon\Db\Adapter\Pdo\TablePrefixInterface;
use Phwoolcon\Log;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migrate extends Command
{
    /**
     * @var \Phalcon\Db\Adapter\Pdo|\Phwoolcon\Db\Adapter\Pdo\Mysql
     */
    protected $db;
    protected $table = 'migrations';
    protected $sql = [];
    protected $migrated = [];
    protected $rawMigrated = [];

    protected function checkMigrationsTable()
    {
        $db = $this->db;
        $db->tableExists($this->table) or $this->createTableOn($db, $this->table, [
            'file'   => ['type' => Column::TYPE_VARCHAR, 'size' => 255, 'notNull' => true, 'primary' => true],
            'run_at' => ['type' => Column::TYPE_TIMESTAMP, 'notNull' => true, 'default' => 'CURRENT_TIMESTAMP'],
        ], [], [
            'TABLE_COLLATION' => 'utf8_unicode_ci',
        ]);
        return $this;
    }

    public function cleanMigrationsTable()
    {
        // @codeCoverageIgnoreStart
        if (!Config::runningUnitTest()) {
            return;
        }
        // @codeCoverageIgnoreEnd
        $this->db = Db::connection();
        $this->db->dropTable($this->table);
        $this->checkMigrationsTable();
    }

    protected function configure()
    {
        $this->setDescription('Run migration scripts.')
            ->setAliases(['migrate:up']);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->db = Db::connection();
        // @codeCoverageIgnoreStart
        if ($this->db instanceof TablePrefixInterface) {
            $this->table = $this->db->prefixTable($this->table);
        }
        // @codeCoverageIgnoreEnd
        parent::execute($input, $output);
    }

    public function fire()
    {
        $this->checkMigrationsTable();
        $this->runMigration();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDefaultTableCharset()
    {
        return Db::getDefaultTableCharset();
    }

    protected function loadMigrated()
    {
        $db = $this->db;
        isset($this->sql[$sqlKey = 'load_migrated']) or $this->sql[$sqlKey] = strtr('SELECT * FROM `table`', [
            '`table`' => $db->escapeIdentifier($this->table),
        ]);
        $this->rawMigrated = $this->db->fetchAll($this->sql[$sqlKey]);
        foreach ($this->rawMigrated as $row) {
            $this->migrated[$row['file']] = $row['run_at'];
        }
        return $this;
    }

    protected function logAndShowInfo($info, $newline = true)
    {
        Log::info($info);
        $newline ? $this->info($info) : $this->output->write("<info>{$info}</info>");
    }

    protected function migrationExecuted($filename, $flag = null)
    {
        $db = $this->db;
        if ($flag === true) {
            $db->insertAsDict($this->table, [
                'file' => $filename,
                'run_at' => $this->migrated[$filename] = date('Y-m-d H:i:s'),
            ]);
            return true;
        }
        if ($flag === false) {
            $db->delete($this->table, strtr('`file` = ?', ['`file`' => $db->escapeIdentifier('file')]), [$filename]);
            unset($this->migrated[$filename]);
            return false;
        }
        $this->migrated or $this->loadMigrated();
        return isset($this->migrated[$filename]);
    }

    protected function runMigration()
    {
        $db = $this->db;
        $migrated = false;
        foreach (glob(migrationPath('*.php')) as $file) {
            $filename = basename($file);
            if ($this->migrationExecuted($filename)) {
                continue;
            }
            $migrated = true;
            $this->logAndShowInfo(sprintf('Start migration "%s"...', $filename), false);
            $db->begin();
            try {
                $migration = include $file;
                if (isset($migration['up']) && is_callable($migration['up'])) {
                    call_user_func($migration['up'], $db, $this);
                }
                $this->migrationExecuted($filename, true);
                $db->commit();
            } // @codeCoverageIgnoreStart
            catch (Exception $e) {
                $db->rollback();
                Log::exception($e);
                $this->error(' [ BAD ] ');
                $this->error($e->getMessage());
                return;
            }
            // @codeCoverageIgnoreEnd
            $this->logAndShowInfo(' [ OK ] ');
        }
        if ($migrated) {
            Db::clearMetadata();
        } // @codeCoverageIgnoreStart
        else {
            $this->info('Nothing to be migrated.');
        }
        // @codeCoverageIgnoreEnd
    }

    public function clearMigratedCache()
    {
        $this->migrated = [];
        $this->rawMigrated = [];
        return $this;
    }

    public function createTableOn(
        Adapter $db,
        $table,
        array $columns,
        array $indexes = [],
        array $options = [],
        array $extraOptions = []
    ) {
        $db->createTable($table, null, array_merge([
            'columns' => array_map(function ($name, $definition) {
                return $definition instanceof Column ? $definition : new Column($name, $definition);
            }, array_keys($columns), $columns),
            'indexes' => array_map(function ($name, $columns) {
                // @codeCoverageIgnoreStart
                if ($columns instanceof Index) {
                    return $columns;
                }
                // @codeCoverageIgnoreEnd
                $columns = (array)$columns;
                $type = isset($columns['type']) ? $columns['type'] : null;
                unset($columns['type']);
                is_numeric($name) and $name = reset($columns);
                return new Index($name, $columns, $type);
            }, array_keys($indexes), $indexes),
            'options' => $options,
        ], $extraOptions));
        return $this;
    }
}
