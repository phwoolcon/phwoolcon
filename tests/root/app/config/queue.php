<?php

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
            'adapter' => 'Phwoolcon\Queue\Adapter\Beanstalkd',
            'host' => '127.0.0.1',
            'port' => 11300,
            'connect_timeout' => 5,
            'persistence' => false,
            'default' => 'default',
        ],
        'file' => [
            'path' => TEST_ROOT_PATH . '/storage/queue',
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
        'adapter' => 'Phwoolcon\Queue\FailedLoggerDb',
        'options' => [
            'connection' => '',
            'table' => 'failed_jobs',
        ],
    ],
];
