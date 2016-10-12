<?php
return [
    'phwoolcon/phwoolcon' => [
        'di' => [
            0 => 'di.php',
        ],
        'commands' => [
            0 => [
                'clear:cache' => 'Phwoolcon\Cli\Command\ClearCacheCommand',
                'migrate' => 'Phwoolcon\Cli\Command\Migrate',
                'migrate:create' => 'Phwoolcon\Cli\Command\MigrateCreate',
                'migrate:revert' => 'Phwoolcon\Cli\Command\MigrateRevert',
                'migrate:list' => 'Phwoolcon\Cli\Command\MigrateList',
                'service' => 'Phwoolcon\Cli\Command\ServiceCommand',
            ],
        ],
        'class_aliases' => [
            0 => [
                'Config' => 'Phwoolcon\Config',
                'Db' => 'Phwoolcon\Db',
                'I18n' => 'Phwoolcon\I18n',
                'Log' => 'Phwoolcon\Log',
                'Queue' => 'Phwoolcon\Queue',
                'Router' => 'Phwoolcon\Router',
                'Session' => 'Phwoolcon\Session',
                'View' => 'Phwoolcon\View',
                'User' => 'Phwoolcon\Model\User',
                'Text' => 'Phwoolcon\Text',
                'DisableSessionFilter' => 'Phwoolcon\Router\Filter\DisableSessionFilter',
                'DisableCsrfFilter' => 'Phwoolcon\Router\Filter\DisableCsrfFilter',
                'MultiFilter' => 'Phwoolcon\Router\Filter\MultiFilter',
            ],
        ],
    ],
];
