<?php
return [
    '_white_list' => [
        'enabled',
        'from.address',
        'from.name',
    ],
    'enabled' => false,

    /**
     *--------------------------------------------------------------------------
     * Email sending driver
     *--------------------------------------------------------------------------
     *
     * Can be 'smtp' or 'sendmail'
     * The 'mail' option is prohibited due to CVE-2016-10033 and CVE-2016-10045
     *
     */
    'driver' => 'smtp',
    'smtp_host' => '',
    'smtp_port' => 25,
    'smtp_encryption' => '', // 'ssl', 'tls' or empty
    'smtp_username' => '',
    'smtp_password' => '',
    'from' => ['address' => 'no-reply@example.com', 'name' => 'Phwoolcon'],

    /**
     *--------------------------------------------------------------------------
     * Asynchronous sending
     *--------------------------------------------------------------------------
     *
     * Store emails in a spool and then send them by a daemon process
     * See "async_email_sending" settings in config file queue.php
     *
     */
    'async' => false,
];
