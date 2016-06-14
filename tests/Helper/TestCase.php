<?php

namespace Phwoolcon\Tests\Helper;

use Phalcon\Di;
use PHPUnit_Framework_TestCase;
use Phwoolcon\Aliases;
use Phwoolcon\Cache;
use Phwoolcon\Config;
use Phwoolcon\Cookies;
use Phwoolcon\Db;
use Phwoolcon\DiFix;
use Phwoolcon\Events;
use Phwoolcon\I18n;
use Phwoolcon\Log;
use Phwoolcon\Session;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var Di
     */
    protected $di;

    public function setUp()
    {
        /* @var Di $di */
        $di = $this->di = Di::getDefault();
        Events::register($di);
        DiFix::register($di);
        Db::register($di);
        Cache::register($di);
        Log::register($di);
        Config::register($di);
        Aliases::register($di);
        I18n::register($this->di);
        Cookies::register($this->di);
        Session::register($di);
        Cache::flush();
        Config::clearCache();
        parent::setUp();
    }
}
