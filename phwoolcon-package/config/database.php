<?php

use Phalcon\Db\Adapter\Pdo\Mysql as PhalconMysql;
use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phalcon\Db\Dialect\Mysql as PhalconMysqlDialect;
use Phwoolcon\Db\Adapter\Pdo\Mysql;
use Phwoolcon\Db\Adapter\Pdo\MysqlDialect;

return [
    '_white_list' => [
        'query_log',
    ],
    'default' => '',
    'connections' => [
        'mysql' => [
            'table_prefix' => $tablePrefix = '',
            'adapter'    => $tablePrefix ? Mysql::class : PhalconMysql::class,
            'host'       => 'localhost',
            'dbname'     => 'dbname',
            'username'   => 'user',
            'password'   => 'password',
            'charset'    => 'utf8mb4',
            'default_table_charset' => 'utf8_unicode_ci',
            'options'               => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8mb4" COLLATE "utf8mb4_unicode_ci"',
            ],
            'dialectClass'          => $tablePrefix ? MysqlDialect::class : PhalconMysqlDialect::class,
            'persistent' => false,
        ],

        'pgsql' => [
            'adapter'  => Postgresql::class,
            'host'     => 'localhost',
            'dbname'   => 'dbname',
            'username' => 'user',
            'password' => 'password',
            'charset'  => 'utf8',
            'table_prefix' => '',
            'schema'   => 'public',
        ],
    ],
    'distributed' => [
        'node_id' => '001',
        'start_time' => 1362931200,
    ],
    'orm_options' => [
        'exceptionOnFailedSave' => true,
    ],
    'query_log' => false,

    'dynamic_model_traits' => [
        /**
         * What are dynamic model traits?
         * In simple terms, they are ORMs, a table-to-object mapping,
         * to introduce properties, getters, setters and finders for `Model` classes.
         *
         * @see https://github.com/phwoolcon/demo/blob/release/vendor/phwoolcon/model_traits.php
         * @see generateModelTraits()
         *
         * The `model_traits.php` file is generated automatically by `bin/update-phwoolcon-package-resource`
         */
        'generate_for_connections' => [
            /**
             * The script will generate dynamic model traits for the default connection.
             * If you want to do this for OTHER connections, please specify them here.
             *
             * For example, if you also want dynamic traits for `pgsql`, just add this in your own config:
             *
             * 'pgsql' => true,
             *
             * The value `true` means to treat this connection, `false` means not to.
             * This provides you a chance to override it with `false` in another config file
             *
             * The DEFAULT connection will always be treated, so don't need to put it here
             */
        ],
    ],
];
