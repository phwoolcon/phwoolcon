<?php
namespace Phwoolcon;

use Phalcon\Security as PhalconSecurity;

class Security extends PhalconSecurity
{

    public static function prepareSignatureData(array $data)
    {
        ksort($data);
        unset($data['sign']);
        $string = [];
        foreach ($data as $k => $v) {
            $string[] = $k . '=' . $v;
        }
        return implode('&', $string);
    }

    public static function sha256($data, $raw = false)
    {
        return hash('sha256', $data, $raw);
    }

    public static function signArrayMd5(array $data, $secret)
    {
        return md5(md5(static::prepareSignatureData($data)) . $secret);
    }

    public static function signArraySha256(array $data, $secret)
    {
        return static::sha256(static::sha256(static::prepareSignatureData($data)) . $secret);
    }

    public static function signArrayHmacSha256(array $data, $secret)
    {
        return hash_hmac('sha256', static::prepareSignatureData($data), $secret);
    }
}
