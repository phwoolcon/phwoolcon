<?php

namespace Phwoolcon\Controller;

use Phwoolcon\Config;
use Phwoolcon\Controller;
use Phwoolcon\Session;

abstract class Admin extends Controller
{

    public function initialize()
    {
        parent::initialize();
        $this->addPageTitle(__(Config::get('view.admin.title_suffix')));
        $this->view->setLayout(Config::get('view.admin.layout'));
        $this->view->isAdmin(true);
    }
}
