<?php

use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phwoolcon\Db\Adapter\Pdo\Mysql;

return [
    '_white_list' => [
        'query_log',
    ],
    'default' => '',
    'connections' => [
        'mysql' => [
            'adapter'    => Mysql::class,
            'host'       => 'localhost',
            'dbname'     => 'dbname',
            'username'   => 'user',
            'password'   => 'password',
            'charset'    => 'utf8mb4',
            'default_table_charset' => 'utf8_unicode_ci',
            'options'    => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8mb4" COLLATE "utf8mb4_unicode_ci"',
            ],
            'persistent' => false,
        ],

        'pgsql' => [
            'adapter'  => Postgresql::class,
            'host'     => 'localhost',
            'dbname'   => 'dbname',
            'username' => 'user',
            'password' => 'password',
            'charset'  => 'utf8',
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
];
