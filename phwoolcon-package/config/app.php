<?php

use Phalcon\Logger;

return [
    '_black_list' => [
        'class_aliases',
        'name',
        'version',
    ],
    'debug' => false,
    'name' => 'Phwoolcon',
    'version' => '1.2.1',
    'cache_config' => true,
    'cache_routes' => false,
    'enable_https' => false,
    'secure_routes' => [],
    'use_lite_router' => true,
    'timezone' => 'UTC',
    'url' => 'http://localhost',
    'site_path' => '',
    'class_aliases' => include $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor/phwoolcon/class_aliases.php',
    'log' => [
        'adapter' => 'file',
        'level' => Logger::NOTICE,
        'file' => 'phwoolcon.log',
    ],
];
