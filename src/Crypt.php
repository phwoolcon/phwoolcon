<?php
namespace Phwoolcon;

use Phalcon\Crypt as PhalconCrypt;

class Crypt extends PhalconCrypt
{
    protected static $opensslCipher = 'AES-256-CBC';
    protected static $ivSize;

    public static function opensslEncrypt($text, $key = null)
    {
        static::$ivSize or static::$ivSize = openssl_cipher_iv_length(static::$opensslCipher);
        $iv = substr(base64_encode(random_bytes(static::$ivSize)), 0, static::$ivSize);
        return $iv . openssl_encrypt($text, static::$opensslCipher, $key, 0, $iv);
    }

    public static function opensslDecrypt($text, $key = null)
    {
        static::$ivSize or static::$ivSize = openssl_cipher_iv_length(static::$opensslCipher);
        $iv = substr($text, 0, static::$ivSize);
        return openssl_decrypt(substr($text, static::$ivSize), static::$opensslCipher, $key, 0, $iv);
    }

    public static function reset()
    {
        static::$opensslCipher = 'AES-256-CBC';
        static::$ivSize = openssl_cipher_iv_length(static::$opensslCipher);
    }
}
