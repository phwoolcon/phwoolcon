<?php
return [
    'debug' => false,
    'name' => 'Phwoolcon',
    'version' => '1.0.x-dev',
    'cache_config' => true,
    'enable_https' => false,
    'secure_routes' => [],
    'autoload' => [
        'namespaces' => [
        ],
    ],
    'timezone' => 'UTC',
    'url' => 'http://localhost',
    'site_path' => '',
    'class_aliases' => include ROOT_PATH . '/vendor/phwoolcon/class_aliases.php',
    'log' => [
        'adapter' => 'file',
        'file' => 'phwoolcon.log',
    ],
    'on_phwoolcon_update' => [
        'replace_config' => true,
    ],
];
