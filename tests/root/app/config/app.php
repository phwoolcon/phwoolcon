<?php

use Phalcon\Logger;
use Phwoolcon\Router\Filter;

return [
    'debug' => true,
    'name' => 'Phwoolcon',
    'version' => '1.0.x-dev',
    'cache_config' => false,
    'enable_https' => false,
    'use_lite_router' => true,
    'secure_routes' => [],
    'autoload' => [
        'namespaces' => [
        ],
    ],
    'timezone' => 'UTC',
    'url' => 'http://localhost',
    'site_path' => '',
    'class_aliases' => [
        'Config' => Phwoolcon\Config::class,
        'Db' => Phwoolcon\Db::class,
        'I18n' => Phwoolcon\I18n::class,
        'Log' => Phwoolcon\Log::class,
        'Queue' => Phwoolcon\Queue::class,
        'Router' => Phwoolcon\Router::class,
        'Session' => Phwoolcon\Session::class,
        'View' => Phwoolcon\View::class,
        'User' => Phwoolcon\Model\User::class,
        'DisableSessionFilter' => Filter\DisableSessionFilter::class,
        'DisableCsrfFilter' => Filter\DisableCsrfFilter::class,
        'MultiFilter' => Filter\MultiFilter::class,
        'Widget' => Phwoolcon\View\Widget::class,
    ],
    'log' => [
        'adapter' => 'file',
        'level' => Logger::SPECIAL,
        'file' => 'phwoolcon.log',
    ],
];
