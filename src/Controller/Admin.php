<?php

namespace Phwoolcon\Controller;

use Phwoolcon\Config;
use Phwoolcon\Controller;
use Phwoolcon\Session;
use Phwoolcon\View;

/**
 * Class Admin
 * @package Phwoolcon\Controller
 *
 * @property View $view
 * @method Controller addPageTitle(string $title)
 */
trait Admin
{

    public function initialize()
    {
        parent::initialize();
        $this->addPageTitle(__(Config::get('view.admin.title_suffix')));
        $this->view->setLayout(Config::get('view.admin.layout'));
        $this->view->isAdmin(true);
    }
}
