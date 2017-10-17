<?php

use Phwoolcon\Cli\Command;
use Phwoolcon\Router\Filter;

return [
    'phwoolcon/phwoolcon' => [
        'di' => [
            0 => 'di.php',
        ],
        'commands' => [
            0 => [
                'clear:cache' => Command\ClearCacheCommand::class,
                'migrate' => Command\Migrate::class,
                'migrate:create' => Command\MigrateCreate::class,
                'migrate:revert' => Command\MigrateRevert::class,
                'migrate:list' => Command\MigrateList::class,
                'service' => Command\ServiceCommand::class,
                'queue:consume' => Command\QueueConsumeCommand::class,
                'phpunit:pick-package' => Command\PhpunitPickPackageCommand::class,
                'package:create' => Command\Package\CreateCommand::class,
            ],
        ],
        'class_aliases' => [
            0 => [
                'Config' => Phwoolcon\Config::class,
                'Db' => Phwoolcon\Db::class,
                'ErrorCodes' => Phwoolcon\ErrorCodes::class,
                'I18n' => Phwoolcon\I18n::class,
                'Log' => Phwoolcon\Log::class,
                'Queue' => Phwoolcon\Queue::class,
                'Router' => Phwoolcon\Router::class,
                'Session' => Phwoolcon\Session::class,
                'View' => Phwoolcon\View::class,
                'User' => Phwoolcon\Model\User::class,
                'Text' => Phwoolcon\Text::class,
                'DisableSessionFilter' => Filter\DisableSessionFilter::class,
                'DisableCsrfFilter' => Filter\DisableCsrfFilter::class,
                'MultiFilter' => Filter\MultiFilter::class,
                'Widget' => Phwoolcon\View\Widget::class,
            ],
        ],
        'assets' => [
            'ie-hack-css' => [],
            'ie-hack-js' => [
                'phwoolcon/ie/html-elements.js',
                'phwoolcon/ie/add-event-listener.js',
                'phwoolcon/ie/es5-shim-4.5.9.min.js',
                'phwoolcon/ie/es5-sham-4.5.9.min.js',
                'phwoolcon/ie/json2.min.js',
                'phwoolcon/ie/es6-shim-0.35.3.min.js',
                'phwoolcon/ie/es6-sham-0.35.3.min.js',
                'phwoolcon/ie/html5shiv-3.7.3.js',
                'phwoolcon/ie/html5-formdata-polyfilll.min.js',
                'phwoolcon/ie/fetch-2.0.3.min.js',
                'phwoolcon/ie/console-fix.js',
            ],
            'ie-hack-body-js' => [],
            'phwoolcon-js' => [
                'phwoolcon/utils.js',
                'phwoolcon/js-cookie-2.1.4.min.js',
                'phwoolcon/simpleStorage-0.2.1.min.js',
                'phwoolcon/phwoolcon.js',
            ],
        ],
    ],
];
