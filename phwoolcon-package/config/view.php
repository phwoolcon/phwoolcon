<?php

return [
    'debug' => false,
    'path' => ROOT_PATH . '/app/views/',
    'theme' => 'default',
    'top_level' => 'html',
    'default_layout' => 'default',
    'title_separator' => ' - ',
    'title_suffix' => 'Phwoolcon',
    'assets' => [
        'head-css' => [
            '../base/css/normalize-4.1.1.css',
            '../base/css/mincss.css',
            'css/styles.css',
            'css/no-js.css',
            '../base/css/font-pt-sans.css',
        ],
        'head-js' => [
            '../base/js/jquery-1.12.3.min.js',
            '../base/js/jquery.cookie-1.4.1.min.js',
            '../base/js/simpleStorage-0.2.1.min.js',
            '../base/js/phwoolcon.js',
        ],
        'body-js' => [
            '../base/js/body-js.js',
        ],
        'ie-hack-css' => [
            '../base/css/ie-hack.css',
        ],
        'ie-hack-js' => [
            '../base/js/ie/function-bind.min.js.js',
            '../base/js/ie/json2-20160501.min.js',
            '../base/js/ie/html5shiv-3.7.3.min.js',
        ],
        'ie-hack-body-js' => [
            '../base/js/ie/jquery.placeholder-2.3.1.min.js',
            '../base/js/ie/respond-1.4.2.js',
            '../base/js/ie/ie-hack.js',
        ],
        'sso-js' => [
            '../base/packages/phwoolcon-auth/sso.js',
        ],
    ],
    'admin' => [
        'title_suffix' => 'Admin',
        'theme' => 'default',
        'layout' => 'default',
        'assets' => [
            'head-css' => [
                '../../base/css/normalize-4.1.1.css',
                '../../base/css/mincss.css',
                'css/styles.css',
            ],
            'head-js' => [
                '../../base/js/jquery-1.12.3.min.js',
                '../../base/js/jquery.cookie-1.4.1.min.js',
                '../../base/js/ie/simpleStorage-0.2.1.min.js',
                '../../base/js/phwoolcon.js',
            ],
            'body-js' => [
                '../../base/js/body-js.js',
            ],
            'ie-hack-css' => [
                '../../base/css/ie-hack.css',
            ],
            'ie-hack-js' => [
                '../../base/js/ie/function-bind.min.js.js',
                '../../base/js/ie/json2-20160501.min.js',
                '../../base/js/ie/html5shiv-3.7.3.min.js',
            ],
            'ie-hack-body-js' => [
                '../../base/js/ie/jquery.placeholder-2.3.1.min.js',
                '../../base/js/ie/respond-1.4.2.js',
                '../../base/js/ie/ie-hack.js',
            ],
        ],
    ],
    'options' => [
        'assets_options' => [
            'base_path' => ROOT_PATH . '/public',
            'assets_dir' => 'assets',
            'cache_assets' => true,
            'apply_filter' => true,
        ],
    ],
    'engines' => [
        '.phtml' => 'Phwoolcon\View\Engine\Php',
    ],
];
