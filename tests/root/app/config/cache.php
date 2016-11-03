<?php
return [
    'default' => extension_loaded('redis') ? 'redis' : 'file',
    'drivers' => [
        'file' => [
            'adapter' => 'Phalcon\Cache\Backend\File',
            'options' => [
                'cacheDir' => 'cache',
                'prefix' => 'c.',
            ],
        ],
        'redis' => [
            'adapter' => 'Phwoolcon\Cache\Backend\Redis',
            'options' => [
                'host' => '127.0.0.1',
                'port' => 6379,
                'index' => 5,
                'persistent' => true,
                'prefix' => 'phw-cache:',
            ],
        ],
        'memcached' => [
            'adapter' => 'Phalcon\Cache\Backend\Libmemcached',
            'options' => [
                'servers' => [
                    ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 1],
                ],
                'client' => class_exists('Memcached') ? [
                    Memcached::OPT_HASH => Memcached::HASH_MD5,
                    Memcached::OPT_PREFIX_KEY => 'phwoolcon.',
                ] : [],
                'statsKey' => '_PHCM',
            ],
        ],
    ],
];
