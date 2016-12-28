<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Cache\Clearer;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\View;

class ViewTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        View::register($this->di);
    }

    public function testGetPhwoolconJsOptions()
    {
        $jsOptions = View::getPhwoolconJsOptions();
        $this->assertArrayHasKey('baseUrl', $jsOptions, 'View::getPhwoolconJsOptions(): baseUrl not set');
        $this->assertArrayHasKey('cookies', $jsOptions, 'View::getPhwoolconJsOptions(): cookies not set');
        $this->assertArrayHasKey(
            'domain',
            fnGet($jsOptions, 'cookies'),
            'View::getPhwoolconJsOptions(): cookies.domain not set'
        );
        $this->assertArrayHasKey(
            'path',
            fnGet($jsOptions, 'cookies'),
            'View::getPhwoolconJsOptions(): cookies.path not set'
        );
    }

    public function testMake()
    {
        View::noHeader(true);
        View::noFooter(true);
        $this->assertEquals("TEST MAKE", View::make('test', 'make'), 'Bad View::make() content');
    }

    public function testPhpTemplateInclude()
    {
        $this->assertEquals("TEST MAKE", View::make('test', 'include'), 'Bad View Php engine include content');
    }

    public function testPageVariables()
    {
        /* @var View $view */
        $view = $this->di->getShared('view');
        $view->setParams($params = [
            'page_title' => 'Test Title',
            'page_keywords' => 'Test Keyword1,Test Keyword2',
            'page_description' => 'Test Description',
        ]);
        $this->assertEquals($params['page_title'], View::getPageTitle());
        $this->assertEquals('zh-CN', View::getPageLanguage());
        $this->assertEquals($params['page_keywords'], View::getPageKeywords());
        $this->assertEquals($params['page_description'], View::getPageDescription());
    }

    public function testAssets()
    {
        /* @var View $view */
        $view = $this->di->getShared('view');
        $view->isAdmin(false);
        $view->cache(true);
        Clearer::clear(Clearer::TYPE_ASSETS);
        $this->assertStringStartsWith('<script type="text/javascript" ', View::generateHeadJs());
        // Test assets cache
        $this->assertStringStartsWith('<script type="text/javascript" ', View::generateHeadJs());
        $this->assertStringStartsWith('<link rel="stylesheet" type="text/css" ', View::generateHeadCss());
        $this->assertStringStartsWith('<link rel="stylesheet" type="text/css" ', View::generateIeHack());
        $this->assertStringStartsWith('<script type="text/javascript" ', View::generateBodyJs());
        $this->assertStringStartsWith('<script type="text/javascript" ', View::generateIeHackBodyJs());
        $this->assertStringStartsWith('<script type="text/javascript" ', View::assets('non-existing-remote-js'));
    }
}
