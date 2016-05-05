<?php
namespace Phwoolcon;

use Exception;
use Phalcon\Cache\BackendInterface;
use Phalcon\Di;
use Phalcon\Mvc\View as PhalconView;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\View\Exception as ViewException;

class View extends PhalconView
{
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var static
     */
    protected static $instance;
    protected $config = [];
    protected $_theme;

    public function __construct($config = null)
    {
        parent::__construct($config['options']);
        $this->setViewsDir($config['path']);
        $this->_mainView = $config['top_level'];
        $this->_theme = $config['theme'];
        $this->_layout = $config['default_layout'];
        $this->config = $config;
    }

    protected function _engineRender($engines, $viewPath, $silence, $mustClean, BackendInterface $cache = null)
    {
        $viewPath == $this->_mainView or $viewPath = trim($this->_theme . '/' . $viewPath, '/');
        $silence = $silence && !$this->config['debug'];
        $this->config['debug'] and $this->_options['debug_wrapper'] = $viewPath;
        parent::_engineRender($engines, $viewPath, $silence, $mustClean, $cache);
    }

    public static function getPageLanguage()
    {
        return strtr(static::getParam('page_language', I18n::getCurrentLocale()), ['_' => '-']);
    }

    public static function getParam($key, $default = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return fnGet(static::$instance->_params, $key, $default, '.');
    }

    public function isAdmin($flag = null)
    {
        if ($flag !== null) {
            $this->_options['is_admin'] = $flag = (bool)$flag;
            $this->_theme = $flag ? 'admin/' . $this->config['admin']['theme'] : $this->config['theme'];
        }
        return !empty(static::$instance->_options['is_admin']);
    }

    public static function make($path, $file, $params = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return static::$instance->reset()->start()->render($path, $file, $params)->finish()->getContent();
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->setShared('view', function () {
            return new static(Config::get('view'));
        });
    }

    public function render($controllerName, $actionName, $params = null)
    {
        try {
            return parent::render($controllerName, $actionName, $params);
        } catch (ViewException $e) {
            Log::exception($e);
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function reset()
    {
        $this->_disabled = false;
        $this->_options = $this->config['options'];
        $this->_theme = $this->config['theme'];
        $this->_layout = $this->config['default_layout'];
        $this->_cache = null;
        $this->_renderLevel = static::LEVEL_MAIN_LAYOUT;
        $this->_cacheLevel = static::LEVEL_NO_RENDER;
        $this->_content = null;
        $this->_templatesBefore = null;
        $this->_templatesAfter = null;
        return $this;
    }

    public function setContent($content)
    {
        if (isset($this->_options['debug_wrapper'])) {
            $debugWrapper = $this->_options['debug_wrapper'];
            $this->_content = "<!-- [{$debugWrapper} -->" . $content . "<!-- {$debugWrapper}] -->";
        } else {
            $this->_content = $content;
        }
        return $this;
    }
}
