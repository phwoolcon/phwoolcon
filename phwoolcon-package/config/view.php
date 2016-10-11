<?php

return [
    'debug' => false,
    'path' => ROOT_PATH . '/app/views/',
    'theme' => 'default',
    'top_level' => 'html',
    'default_layout' => 'default',
    'title_separator' => ' - ',
    'title_suffix' => 'Phwoolcon',
    'assets' => include ROOT_PATH . '/vendor/phwoolcon/assets.php',
    'admin' => [
        'title_suffix' => 'Admin',
        'theme' => 'default',
        'layout' => 'default',
        'assets' => include ROOT_PATH . '/vendor/phwoolcon/admin_assets.php',
    ],
    'options' => [
        'assets_options' => [
            'base_path' => ROOT_PATH . '/public',
            'assets_dir' => 'assets',
            'compiled_dir' => 'static',
            'cache_assets' => true,
            'apply_filter' => true,
        ],
    ],
    'engines' => [
        '.phtml' => 'Phwoolcon\View\Engine\Php',
    ],
];
