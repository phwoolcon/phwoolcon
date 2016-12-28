<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cache\Clearer;
use Phwoolcon\Config;
use Phwoolcon\Cookies;
use Phwoolcon\I18n;
use Phwoolcon\Session;
use Phwoolcon\Tests\Helper\TestCase;

class I18nTest extends TestCase
{
    protected $eventChangeValue = false;

    public function setUp()
    {
        parent::setUp();
        Clearer::clear(Clearer::TYPE_LOCALE);
    }

    public function testTranslate()
    {
        I18n::clearCache();
        I18n::staticReset();
        $this->assertEquals('测试', __('Test'), 'Bad translate result');
        $this->assertEquals('测试1', __('Test', [], 'another-package'), 'Bad translate result with package');
        $this->assertEquals($someString = 'Some string', __($someString), 'Bad translate result with undefined string');
        $this->assertEquals('Some words', __('Some %stuff%', ['stuff' => 'words']), 'Bad translate result with params');
    }

    public function testAvailableLocales()
    {
        $this->assertEquals(Config::get('i18n.available_locales'), I18n::getAvailableLocales(), 'Bad locales list');
    }

    public function testSetLocale()
    {
        Session::start();
        $currentLocale = I18n::getCurrentLocale();
        $_REQUEST['_locale'] = 'en';
        I18n::staticReset();
        $this->assertEquals('en', I18n::getCurrentLocale(), 'Unable to set locale via request');
        $_REQUEST['_locale'] = $currentLocale;
        I18n::staticReset();
        unset($_REQUEST['_locale']);
        I18n::setLocale('en');
        $this->assertEquals('en', I18n::getCurrentLocale(), 'Unable to set locale via setLocale()');
        I18n::setLocale($currentLocale);
        $this->assertEquals($currentLocale, I18n::getCurrentLocale(), 'Unable to set locale via setLocale()');
        I18n::setLocale('non-existing');
        $this->assertEquals(
            $currentLocale,
            I18n::getCurrentLocale(),
            'Unable to restore default locale via setLocale()'
        );
        Session::end();

        I18n::clearCache(true);
        Cookies::set('locale', 'en');
        Session::start();
        I18n::staticReset();
        $this->assertEquals('en', I18n::getCurrentLocale(), 'Unable to set locale via cookie');
        $_REQUEST['_locale'] = $currentLocale;
        I18n::staticReset();
        unset($_REQUEST['_locale']);
        Session::set('current_locale', 'en');
        I18n::staticReset();
        $this->assertEquals('en', I18n::getCurrentLocale(), 'Unable to set locale via session');
        Session::set('current_locale', null);
        I18n::staticReset();
        $this->assertEquals($currentLocale, I18n::getCurrentLocale(), 'Unable to restore default locale');
        Session::end();
    }

    public function testDisableMultiLocale()
    {
        I18n::useMultiLocale(false);
        $currentLocale = I18n::getCurrentLocale();
        $_REQUEST['_locale'] = 'en';
        I18n::staticReset();
        $this->assertEquals($currentLocale, I18n::getCurrentLocale(), 'Unable to disable multi locale');
        $_REQUEST['_locale'] = 'zh_CN';
        I18n::staticReset();
        $this->assertEquals($currentLocale, I18n::getCurrentLocale(), 'Unable to disable multi locale');
        unset($_REQUEST['_locale']);
        I18n::useMultiLocale(true);
    }

    public function testCheckMobile()
    {
        $mobile = '13579246801';
        $this->assertTrue(I18n::checkMobile($mobile, 'CN'), 'Bad check mobile result');
    }

    public function testFormatPrice()
    {
        $amount = '1234.5';
        $this->assertEquals('￥1,234.50', price($amount));
    }
}
