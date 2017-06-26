<?php

namespace Phwoolcon\Tests\Helper;

use Phalcon\Di;
use Phalcon\Version;
use PHPUnit\Framework\TestCase as PhpunitTestCase;
use Phwoolcon\Aliases;
use Phwoolcon\Cache;
use Phwoolcon\Cache\Clearer;
use Phwoolcon\Config;
use Phwoolcon\Cookies;
use Phwoolcon\Db;
use Phwoolcon\DiFix;
use Phwoolcon\Events;
use Phwoolcon\I18n;
use Phwoolcon\Log;
use Phwoolcon\Session;
use Phwoolcon\Util\Counter;
use Phwoolcon\Util\Timer;
use Swoole\Process as SwooleProcess;

class TestCase extends PhpunitTestCase
{
    /**
     * @var Di
     */
    protected $di;

    public function appendRemoteCoverage()
    {
        foreach ($this->getRemoteCoverageFiles() as $coverageFile) {
            $this->getTestResultObject()->getCodeCoverage()->append(include $coverageFile);
            unlink($coverageFile);
        }
    }

    public function generateRemoteCoverageFile()
    {
        return tempnam(storagePath('remote-coverage'), 'cov-' . time() . '-');
    }

    public function getRemoteCoverageFiles()
    {
        return glob(storagePath('remote-coverage/cov-*'));
    }

    /*public function runIsolate($realMethod)
    {
        $serverProcess = new SwooleProcess(function () use ($realMethod) {
            $this->{$realMethod}();
            $this->writeRemoteCoverage();
        }, true);
        $serverProcess->start();
        Db::reconnect();
    }*/

    public function setUp()
    {
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['PHWOOLCON_PHALCON_VERSION'] = Version::getId();
        /* @var Di $di */
        $di = $this->di = Di::getDefault();
        Events::register($di);
        DiFix::fix($di);
        Db::register($di);
        Cache::register($di);
        Log::register($di);
        Config::register($di);
        Counter::register($this->di);
        Aliases::register($di);
        I18n::register($di);
        Cookies::register($di);
        Session::register($di);
        Clearer::clear();
        parent::setUp();

        $class = get_class($this);
        Log::debug("================== Running {$class}::{$this->getName()}() ... ==================");
        Timer::start();
    }

    public function tearDown()
    {
        $elapsed = Timer::stop();
        parent::tearDown();
        Log::debug("================== Finished, time elapsed: {$elapsed}. ==================");
    }

    public function writeRemoteCoverage()
    {
        $coverage = $this->getTestResultObject()->getCodeCoverage();
        $coverage->stop();
        $data = $coverage->getData(true);
        foreach ($data as $file => &$lines) {
            foreach ($lines as $line => &$executed) {
                $executed and $executed = 1;
            }
            unset($executed);
        }
        unset($lines);
        fileSaveArray($this->generateRemoteCoverageFile(), $data);
    }
}
