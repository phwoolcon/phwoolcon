<?php

use Phwoolcon\Queue\Adapter\Beanstalkd;
use Phwoolcon\Queue\Adapter\DbQueue;
use Phwoolcon\Queue\FailedLoggerDb;

return [
    'default' => 'default_queue',

    /*
    |--------------------------------------------------------------------------
    | Queues
    |--------------------------------------------------------------------------
    |
    | Configure the queues by purpose here.
    |
    */
    'queues' => [
        'default_queue' => [
            'connection' => 'beanstalkd',
            'options' => [
                'default' => 'phwoolcon-test',
            ],
        ],
        'async_email_sending' => [
            'connection' => 'db',
            'options' => [
                'default' => 'async_email_sending',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Configure the connection information for each queue server.
    |
    */
    'connections' => [
        'beanstalkd' => [
            'adapter' => Beanstalkd::class,
            'host' => '127.0.0.1',
            'port' => 11300,
            'connect_timeout' => 5,
            'read_timeout' => 1,
            'persistence' => false,
            'default' => 'default',
        ],
        'file' => [
            'path' => $_SERVER['PHWOOLCON_ROOT_PATH'] . '/storage/queue',
            'ext' => '.data',
        ],
        'db' => [
            'adapter' => DbQueue::class,
            'database_connection' => '', // Leave empty to use default connection. See config file database.php
            'table' => 'queue_jobs',
            'time_to_run' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | Configure the behavior of failed queue job logging so you
    | can store the jobs that have failed.
    |
    */
    'failed_logger' => [
        'adapter' => FailedLoggerDb::class,
        'options' => [
            'connection' => '',
            'table' => 'failed_jobs',
        ],
    ],
];
