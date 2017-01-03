<?php

use Phwoolcon\Queue\Adapter\Beanstalkd;
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
            'options' => [],
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
            'persistence' => false,
            'default' => 'default',
        ],
        'file' => [
            'path' => ROOT_PATH . '/storage/queue',
            'ext' => '.data',
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
