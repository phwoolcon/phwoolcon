<?php
namespace Phwoolcon\Http;

use Phalcon\CryptInterface;
use Phalcon\Di;
use Phalcon\Http\Cookie as PhalconCookie;
use Phwoolcon\Cache;
use Phwoolcon\Cookies;

/**
 * Class Cookie
 * @package Phwoolcon\Http
 *
 * @property Di $_dependencyInjector
 */
class Cookie extends PhalconCookie
{

    public function delete()
    {
        $this->_value = null;
        Cookies::set(
            $this->_name,
            $this->_value,
            time() - Cache::TTL_ONE_MONTH,
            $this->_path,
            $this->_secure,
            $this->_domain,
            $this->_httpOnly
        )->get($this->_name)->useEncryption(false);
    }

    public function getResponseValue()
    {
        if ($this->_useEncryption && $this->_value) {
            /* @var CryptInterface $crypt */
            $crypt = $this->_dependencyInjector->getShared('crypt');
            return $crypt->encryptBase64((string)$this->_value);
        }
        return $this->_value;
    }
}
