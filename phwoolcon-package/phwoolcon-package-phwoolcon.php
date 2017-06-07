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
            ],
        ],
        'class_aliases' => [
            0 => [
                'Config' => Phwoolcon\Config::class,
                'Db' => Phwoolcon\Db::class,
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
    ],
];
