<?php

use Phalcon\Db\Adapter\Pdo as Adapter;
use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phwoolcon\Cli\Command\Migrate;

return [
    'up' => function (Adapter $db, Migrate $migrate) {
    },
    'down' => function (Adapter $db, Migrate $migrate) {
    },
];
