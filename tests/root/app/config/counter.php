<?php
return [
    'default' => 'auto',
    'drivers' => [
        'auto' => [
            'adapter' => 'Phwoolcon\Util\Counter\Adapter\Auto',
            'options' => [],
        ],
        'rds' => [
            'adapter' => 'Phwoolcon\Util\Counter\Adapter\Rds',
            'options' => [
                'table' => 'counter',
            ],
        ],
        'cache' => [
            'adapter' => 'Phwoolcon\Util\Counter\Adapter\Cache',
            'options' => [],
        ],
    ],
];
