<?php
return [
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'adapter'    => 'Phwoolcon\Db\Adapter\Pdo\Mysql',
            'host'       => '127.0.0.1',
            'dbname'     => 'phwoolcon_test',
            'username'   => 'travis',
            'password'   => '',
            'charset'    => 'utf8mb4',
            'default_table_charset' => 'utf8_unicode_ci',
            'options'    => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8mb4" COLLATE "utf8mb4_unicode_ci"',
            ],
            'persistent' => false,
        ],

        'pgsql' => [
            'adapter'  => 'Phalcon\Db\Adapter\Pdo\Postgresql',
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
];
