<?php
return [
    'debug' => true,
    'cache_config' => false,
    'enable_https' => false,
    'secure_routes' => [],
    'autoload' => [
        'namespaces' => [
        ],
    ],
    'timezone' => 'UTC',
    'url' => 'http://localhost',
    'site_path' => '',
    'class_aliases' => [
        'Config' => 'Phwoolcon\Config',
        'Db' => 'Phwoolcon\Db',
        'I18n' => 'Phwoolcon\I18n',
        'Log' => 'Phwoolcon\Log',
        'Queue' => 'Phwoolcon\Queue',
        'Router' => 'Phwoolcon\Router',
        'Session' => 'Phwoolcon\Session',
        'View' => 'Phwoolcon\View',
        'User' => 'Phwoolcon\Model\User',
        'DisableSessionFilter' => 'Phwoolcon\Router\Filter\DisableSessionFilter',
        'DisableCsrfFilter' => 'Phwoolcon\Router\Filter\DisableCsrfFilter',
        'MultiFilter' => 'Phwoolcon\Router\Filter\MultiFilter',
    ],
    'log' => [
        'adapter' => 'file',
        'file' => 'phwoolcon.log',
    ],
];
