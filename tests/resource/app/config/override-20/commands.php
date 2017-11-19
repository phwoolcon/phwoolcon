<?php
use Phwoolcon\Cli\Command\ClearCacheCommand;
use Phwoolcon\Cli\Command\Migrate;
use Phwoolcon\Cli\Command\MigrateCreate;
use Phwoolcon\Cli\Command\MigrateList;
use Phwoolcon\Cli\Command\MigrateRevert;
use Phwoolcon\Cli\Command\QueueConsumeCommand;
use Phwoolcon\Tests\Helper\Cli\TestCommand;

return [
    'test-command' => TestCommand::class,
    'clear:cache' => ClearCacheCommand::class,
    'migrate' => Migrate::class,
    'migrate:create' => MigrateCreate::class,
    'migrate:revert' => MigrateRevert::class,
    'migrate:list' => MigrateList::class,
    'queue:consume' => QueueConsumeCommand::class,
];
