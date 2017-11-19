<?php

return [
    'assets' => [
        'head-css' => [
            'css/test.css',
        ],
        'head-js' => [
            'js/test.js',
        ],
        'body-js' => [
            'js/test.js',
        ],
        'ie-hack-css' => [
        ],
        'ie-hack-js' => [
        ],
        'ie-hack-body-js' => [
        ],
        'non-existing-remote-js' => [
            'http://127.0.0.1:8888/non-existing.js',
        ],
    ],
    'admin' => [
        'title_suffix' => 'Admin',
        'theme' => 'default',
        'layout' => 'default',
        'assets' => [
            'head-css' => [
                'test.css',
            ],
            'head-js' => [
                'test.js',
            ],
            'body-js' => [
                'test-body.js',
            ],
            'ie-hack-css' => [
                'test-ie-hack.css',
            ],
            'ie-hack-js' => [
                'test-ie-hack.js',
            ],
            'ie-hack-body-js' => [
                'test-ie-hack-body.js',
            ],
        ],
    ],
    'options' => [
        'assets_options' => [
            'cdn_prefix' => 'https://cdn.example.com',
        ],
    ],
];
