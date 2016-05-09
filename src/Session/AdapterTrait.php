<?php

namespace Phwoolcon\Session;

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
    protected $cookieRenewedAt = 0;

    public function end()
    {
        if ($this->_started) {
            $this->setCookie();
            session_write_close();
            session_unset();
            unset($_SESSION);
        }
        $this->_started = false;
        $this->cookieRenewedAt = 0;
    }

    public function get($index, $defaultValue = null, $remove = false)
    {
        $this->_uniqueId and $index = $this->_uniqueId . '#' . $index;
        $value = fnGet($_SESSION, $index, $defaultValue, '.');
        $remove and array_forget($_SESSION, $index);
        return $value;
    }

    public function generateCsrfToken()
    {
        $this->set('csrf_token', $token = $this->generateRandomString());
        $this->set('csrf_token_expire', time() + $this->_options['csrf_token_lifetime']);
        return $token;
    }

    public function generateRandomString()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    public function getCsrfToken()
    {
        return ($this->get('csrf_token_expire') > time() && $token = $this->get('csrf_token')) ?
            $token :
            $this->generateCsrfToken();
    }

    protected function isValidSid($value)
    {
        return isset($value{31}) && !isset($value{32}) && ctype_xdigit($value);
    }

    public function readCookieAndStart()
    {
        if (!$this->_started && $this->status() !== self::SESSION_ACTIVE) {
            $this->isValidSid($sid = Cookies::get($this->getName())->useEncryption(false)->getValue()) ?
                $this->setId($sid) : $this->regenerateId();
            session_start();
            $this->_options['cookie_lazy_renew_interval'] and $this->cookieRenewedAt = $this->get('_cookie_renewed_at');
            $this->_started = true;
            return true;
        }
        return false;
    }

    public function regenerateId($deleteOldSession = true)
    {
        session_regenerate_id($deleteOldSession);
        $this->setId($this->generateRandomString());
        $this->cookieRenewedAt = 0;
        return $this;
    }

    public function set($index, $value)
    {
        $this->_uniqueId and $index = $this->_uniqueId . '#' . $index;
        array_set($_SESSION, $index, $value);
    }

    public function setCookie()
    {
        $now = time();
        if ($lazyRenew = $this->_options['cookie_lazy_renew_interval']) {
            if ($this->cookieRenewedAt + $lazyRenew > $now) {
                return $this;
            }
            $this->set('_cookie_renewed_at', $now);
        }
        Cookies::set($cookieName = $this->getName(), $this->getId(), $now + $this->_options['lifetime'],
            $this->_options['cookie_path'], $this->_options['cookie_secure'], $this->_options['cookie_domain'],
            $this->_options['cookie_http_only']
        );
        Cookies::get($cookieName)->useEncryption(false);
        return $this;
    }

    public function start()
    {
        return $this->readCookieAndStart();
    }
}
