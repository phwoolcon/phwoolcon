<?php
return [
    'enabled' => true,
    'driver' => 'smtp',
    'smtp_host' => 'localhost',
    'smtp_port' => 2500,
    'smtp_encryption' => '', // 'ssl', 'tls' or empty
    'smtp_username' => '',
    'smtp_password' => '',
    'sender' => ['address' => 'no-reply@example.com', 'name' => 'Phwoolcon'],
    'async' => false,
];
