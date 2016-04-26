<?php

namespace Phwoolcon\Session;

trait StartTrait
{

    public function start()
    {
        if (!headers_sent()) {
            if (!$this->_started && $this->status() !== self::SESSION_ACTIVE) {
                session_start();
                $this->_started = true;
                return true;
            }
        }
        return false;
    }

    public function end()
    {
        if ($this->_started) {
            session_write_close();
            $this->_started = false;
        }
    }
}
