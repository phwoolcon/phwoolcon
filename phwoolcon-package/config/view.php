<?php

return [
    '_white_list' => [
        'debug',
        'top_level',
        'theme',
        'default_layout',
        'title_separator',
        'title_suffix',
        'admin.title_suffix',
        'admin.theme',
        'admin.layout',
        'options.assets_options.cache_assets',
        'options.assets_options.apply_filter',
    ],
    'debug' => false,
    'path' => $_SERVER['PHWOOLCON_ROOT_PATH'] . '/app/views/',
    'theme' => 'default',
    'top_level' => 'html',
    'default_layout' => 'default',
    'title_separator' => ' - ',
    'title_suffix' => 'Phwoolcon',
    'assets' => include $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor/phwoolcon/assets.php',
    'admin' => [
        'title_suffix' => 'Admin',
        'theme' => 'default',
        'layout' => 'default',
        'assets' => include $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor/phwoolcon/admin_assets.php',
    ],
    'options' => [
        'assets_options' => [
            'base_path' => $_SERVER['PHWOOLCON_ROOT_PATH'] . '/public',
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
