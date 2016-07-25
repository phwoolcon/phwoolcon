<?php
return [
    'locale_path' => TEST_ROOT_PATH . '/app/locale',
    'cache_locale' => true,
    'multi_locale' => true,
    'default_locale' => 'zh_CN',
    'available_locales' => [
        'en' => 'English',
        'zh_CN' => '简体中文',
    ],
    'detect_client_locale' => false,
    'verification_patterns' => [
        'CN' => [
            'mobile' => '/^1[34578]\d{9}$/',
            'zip_code' => '/^\d{6}$/',
        ],
    ],
    'undefined_strings_log' => 'logs/undefined_strings_log.php',
];
