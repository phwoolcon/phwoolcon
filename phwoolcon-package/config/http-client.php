<?php
return [
    'connect_time_out' => 10,
    'time_out'         => 10,
    'verify_ssl'       => true,
    'user_agent'       => 'Phwoolcon HTTP Client; +https://github.com/phwoolcon',

    /**
     * --------------------------------------------------------------------------
     * Proxy setting
     * --------------------------------------------------------------------------
     * '[scheme://]host:port', e.g.:
     * 'socks5://127.0.0.1:8080'
     *
     * @see https://curl.haxx.se/libcurl/c/CURLOPT_PROXY.html
     */
    'proxy'            => null,

    /**
     * --------------------------------------------------------------------------
     * Custom DNS resolving
     * --------------------------------------------------------------------------
     * array of 'host:port:ip', e.g.:
     * ['www.example.com:443:172.16.1.1', 'abc.example.com:80:172.16.1.1']
     */
    'custom_dns'       => [],

    /**
     * --------------------------------------------------------------------------
     * Additional cURL options
     * --------------------------------------------------------------------------
     *
     * @see https://secure.php.net/manual/en/function.curl-setopt.php
     */
    'curl_options'     => [],
];
