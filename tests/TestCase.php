<?php

namespace Phwoolcon\Tests;

use Phalcon\Di;
use PHPUnit_Framework_TestCase;
use Phwoolcon\Aliases;
use Phwoolcon\Cache;
use Phwoolcon\Config;
use Phwoolcon\Db;
use Phwoolcon\DiFix;
use Phwoolcon\Events;
use Phwoolcon\Log;

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
        Cache::flush();
        Config::clearCache();
        parent::setUp();
    }
}
