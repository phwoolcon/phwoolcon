<?php
namespace Phwoolcon\View\Engine;

use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phwoolcon\View;

/**
 * Class Php
 * @package Phwoolcon\View\Engine
 *
 * @property View $_view
 * @method void include(string $path, $params = [])
 */
class Php extends PhpEngine
{
    protected $_debug;

    /**
     * Php constructor.
     * @param View        $view
     * @param \Phalcon\Di $di
     */
    public function __construct($view, $di)
    {
        parent::__construct($view, $di);
        $this->_debug = $view::getConfig('debug');
    }

    public function __call($name, $params)
    {
        call_user_func_array([$this, 'process' . ucfirst($name)], $params);
    }

    public function processInclude($path, $params = [])
    {
        if ($this->_debug) {
            $wrapper = $this->_view->getDebugWrapper($path);
            echo $wrapper[0];
            $this->render($this->_view->getAbsoluteViewPath($path . '.phtml'), $params);
            echo $wrapper[1];
            return;
        }
        $this->render($this->_view->getAbsoluteViewPath($path . '.phtml'), $params);
    }
}
