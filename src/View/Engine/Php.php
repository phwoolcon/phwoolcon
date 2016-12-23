<?php
namespace Phwoolcon\View\Engine;

use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Exception;
use Phwoolcon\View;

/**
 * Class Php
 * @package Phwoolcon\View\Engine
 *
 * @property View $_view
 * @method void include(string $path, $params = [])
 * @uses \Phwoolcon\View\Engine\Php::processInclude()
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
        if (!is_file($fullPath = $this->_view->getAbsoluteViewPath($path . '.phtml'))) {
            // @codeCoverageIgnoreStart
            if ($this->_debug) {
                throw new Exception("View file '{$fullPath}' was not found");
            }
            return;
            // @codeCoverageIgnoreEnd
        }
        // @codeCoverageIgnoreStart
        if ($this->_debug) {
            $wrapper = $this->_view->getDebugWrapper($path);
            echo $wrapper[0];
            $this->render($fullPath, $params);
            echo $wrapper[1];
            return;
        }
        // @codeCoverageIgnoreEnd
        $this->render($fullPath, $params);
    }
}
