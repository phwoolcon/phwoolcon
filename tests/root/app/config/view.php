<?php

return [
    'debug' => false,
    'path' => TEST_ROOT_PATH . '/app/views/',
    'theme' => 'default',
    'top_level' => 'html',
    'default_layout' => 'default',
    'title_separator' => ' - ',
    'title_suffix' => 'Phwoolcon',
    'assets' => [
        'head-css' => [
        ],
        'head-js' => [
        ],
        'body-js' => [
        ],
        'ie-hack-css' => [
        ],
        'ie-hack-js' => [
        ],
        'ie-hack-body-js' => [
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
            'base_path' => TEST_ROOT_PATH . '/public',
            'assets_dir' => 'assets',
            'cache_assets' => true,
            'apply_filter' => true,
        ],
    ],
    'engines' => [
        '.phtml' => 'Phwoolcon\View\Engine\Php',
    ],
];
