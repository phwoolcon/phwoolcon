<?php

namespace Phwoolcon\Session;

use Phwoolcon\Config;
use Phwoolcon\Cookies;

/**
 * Class AdapterTrait
 * @package Phwoolcon\Session
 *
 * @property bool $_options
 * @property bool $_started
 * @property string $_uniqueId
 */
trait AdapterTrait
{

    public function end()
    {
        if ($this->_started) {
            session_write_close();
            session_unset();
            unset($_SESSION);
            $this->_started = false;
        }
    }

    public function get($index, $defaultValue = null, $remove = false)
    {
        $this->_uniqueId and $index = $this->_uniqueId . '#' . $index;
        $value = fnGet($_SESSION, $index, $defaultValue, '.');
        $remove and array_forget($_SESSION, $index);
        return $value;
    }

    public function readCookieAndStart()
    {
        if (!$this->_started && $this->status() !== self::SESSION_ACTIVE) {
            ($sid = Cookies::get($this->getName())->useEncryption(false)->getValue()) ?
                $this->setId($sid) : $this->regenerateId();
            session_start();
            $this->_started = true;
            return true;
        }
        return false;
    }

    public function regenerateId($deleteOldSession = true)
    {
        session_regenerate_id($deleteOldSession);
        $this->setId(md5(openssl_random_pseudo_bytes(32)));
        return $this->regenerateIdAndSetCookie();
    }

    public function regenerateIdAndSetCookie()
    {
        Cookies::set($cookieName = $this->getName(), $this->getId(), time() + $this->_options['lifetime'],
            $this->_options['cookie_path'], $this->_options['cookie_secure'], $this->_options['cookie_domain'],
            $this->_options['cookie_http_only']
        );
        Cookies::get($cookieName)->useEncryption(false);
        return $this;
    }

    public function set($index, $value)
    {
        $this->_uniqueId and $index = $this->_uniqueId . '#' . $index;
        array_set($_SESSION, $index, $value);
    }

    public function start()
    {
        return $this->readCookieAndStart();
    }
}
