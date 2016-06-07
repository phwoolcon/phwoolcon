<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Config;
use Phwoolcon\Cookies;
use Phwoolcon\Session;
use Phwoolcon\Tests\TestCase;

class SessionTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function realTestSessionCRUD($driver)
    {
        Config::set('session.default', $driver);
        Session::register($this->di);
        $messageSuffix = " ({$driver})";
        Session::flush();
        // Start session
        $this->assertFalse(isset($_SESSION), '$_SESSION should not exist before session start' . $messageSuffix);
        $this->assertTrue(Session::start(), 'Failed to start session' . $messageSuffix);
        $this->assertFalse(Session::start(), 'Should not start duplicated sessions' . $messageSuffix);

        // Get session id
        $this->assertNotEmpty($sid = Session::getId(), 'Session id not generated');

        // Session detection
        $this->assertTrue(isset($_SESSION), '$_SESSION should exist after session start' . $messageSuffix);
        $this->assertFalse(isset($_SESSION[$key = 'test_key']), 'Session value should not exist before set' . $messageSuffix);

        // Set session value
        Session::set($key, $value = 'Test value');
        $this->assertTrue(isset($_SESSION[$key]), 'Session value should exist after set' . $messageSuffix);
        $this->assertEquals($value, $_SESSION[$key], 'Bad session set result' . $messageSuffix);

        // Update session value
        Session::set($key, $value = 'Test value 2');
        $this->assertEquals($value, $_SESSION[$key], 'Bad session update result' . $messageSuffix);

        // Delete session value
        Session::remove($key);
        $this->assertFalse(isset($_SESSION[$key]), 'Session value should be deleted' . $messageSuffix);

        // Load existing session
        Session::set($key, $value);
        Session::end();
        $this->assertEquals($sid, Cookies::get('phwoolcon')->getValue(), 'Session cookie not set properly' . $messageSuffix);
        $this->assertFalse(isset($_SESSION), '$_SESSION should be ended' . $messageSuffix);
        $this->assertTrue(Session::start(), 'Failed to restart session' . $messageSuffix);
        $this->assertEquals($value, $_SESSION[$key], 'Bad session load result' . $messageSuffix);
        Session::end();
    }

    public function testSessionCRUDNative()
    {
        $this->realTestSessionCRUD('native');
    }

    public function testSessionCRUDRedis()
    {
        if (!extension_loaded('redis')) {
            $this->markTestSkipped('The "redis" extension is not available.');
            return;
        }
        $this->realTestSessionCRUD('redis');
    }

    public function testSessionCRUDMemcached()
    {
        if (!extension_loaded('memcached')) {
            $this->markTestSkipped('The "memcached" extension is not available.');
            return;
        }
        $this->realTestSessionCRUD('memcached');
    }

    public function testSessionFormData()
    {
        Config::set('session.default', 'native');
        Session::register($this->di);
        Session::start();
        Session::rememberFormData($key = 'test-form', $value = ['k' => $v = 'v']);
        $this->assertEquals($value, Session::getFormData($key), 'Session form data not set properly');
        $this->assertEquals($v, Session::getFormData($key . '.k'), 'Unable to fetch sub element from form data');
        $this->assertNull(Session::getFormData($badKey = 'bad-key'), 'Should get null for non-existing form data');
        $this->assertEquals($v, Session::getFormData($badKey, $v), 'Unable to return default value');
        Session::clearFormData($key);
        $this->assertNull(Session::getFormData($key), 'Unable to clear session form data');
        Session::end();
    }

    public function testSessionCsrfToken()
    {
        Config::set('session.default', 'native');
        Session::register($this->di);
        Session::start();
        $this->assertNotEmpty($csrf = Session::generateCsrfToken(), 'Unable to generate CSRF token');
        $this->assertEquals($csrf, Session::getCsrfToken(), 'Unable to check CSRF token');
        Session::clear();
        $this->assertNotEmpty($newCsrf = Session::getCsrfToken(), 'Unable to regenerate CSRF token');
        $this->assertNotEquals($csrf, $newCsrf, 'Unable to regenerate unique CSRF token');
        Session::end();
    }
}
