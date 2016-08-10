<?php

namespace Phwoolcon\Session;

use Phwoolcon\Cookies;
use Phwoolcon\Text;

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

    public function clear()
    {
        $this->cookieRenewedAt = 0;
        $_SESSION = [];
    }

    public function clearFormData($key)
    {
        $this->remove('form_data.' . $key);
    }

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

    abstract public function flush();

    public function generateCsrfToken()
    {
        $this->set('csrf_token', $token = Text::token());
        $this->set('csrf_token_expire', time() + $this->_options['csrf_token_lifetime']);
        return $token;
    }

    public function get($index, $defaultValue = null, $remove = false)
    {
        $this->_uniqueId and $index = $this->_uniqueId . '#' . $index;
        $value = fnGet($_SESSION, $index, $defaultValue, '.');
        $remove and array_forget($_SESSION, $index);
        return $value;
    }

    public function getCsrfToken($renew = false)
    {
        $result = ($this->get('csrf_token_expire') > ($now = time()) && $token = $this->get('csrf_token')) ?
            $token :
            $this->generateCsrfToken();
        $renew and $this->set('csrf_token_expire', $now + $this->_options['csrf_token_lifetime']);
        return $result;
    }

    public function getFormData($key, $default = null)
    {
        return $this->get('form_data.' . $key, $default);
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
        $this->setId(Text::token());
        $this->cookieRenewedAt = 0;
        return $this;
    }

    public function rememberFormData($key, $data)
    {
        $this->set('form_data.' . $key, $data);
    }

    public function remove($index)
    {
        $this->_uniqueId and $index = $this->_uniqueId . '#' . $index;
        array_forget($_SESSION, $index);
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
            $this->set('_cookie_renewed_at', $this->cookieRenewedAt = $now);
        }
        Cookies::set(
            $cookieName = $this->getName(),
            $this->getId(),
            $now + $this->_options['lifetime'],
            $this->_options['cookies']['path'],
            $this->_options['cookies']['secure'],
            $this->_options['cookies']['domain'],
            $this->_options['cookies']['http_only']
        );
        Cookies::get($cookieName)->useEncryption(false);
        return $this;
    }

    public function start()
    {
        return $this->readCookieAndStart();
    }
}
