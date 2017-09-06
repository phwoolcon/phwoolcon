<?php

use Phalcon\Logger;

return [
    '_black_list' => [
        'autoload',
        'class_aliases',
        'on_phwoolcon_update',
        'name',
        'version',
    ],
    'debug' => false,
    'name' => 'Phwoolcon',
    'version' => '1.0.6',
    'cache_config' => true,
    'cache_routes' => false,
    'enable_https' => false,
    'secure_routes' => [],
    'use_lite_router' => true,
    'autoload' => [
        'namespaces' => [
        ],
    ],
    'timezone' => 'UTC',
    'url' => 'http://localhost',
    'site_path' => '',
    'class_aliases' => include $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor/phwoolcon/class_aliases.php',
    'log' => [
        'adapter' => 'file',
        'level' => Logger::NOTICE,
        'file' => 'phwoolcon.log',
    ],
    'on_phwoolcon_update' => [
        'replace_config' => true,
    ],
];
