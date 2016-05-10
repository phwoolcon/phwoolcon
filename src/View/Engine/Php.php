<?php
namespace Phwoolcon\View\Engine;

use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phwoolcon\View;

/**
 * Class Php
 * @package Phwoolcon\View\Engine
 *
 * @property View $view
 * @method void include(string $path, $params = [])
 */
class Php extends PhpEngine
{

    public function __call($name, $params)
    {
        call_user_func_array([$this, 'process' . ucfirst($name)], $params);
    }

    public function processInclude($path, $params = [])
    {
        $this->render($this->view->getAbsoluteViewPath($path . '.phtml'), $params);
    }
}
