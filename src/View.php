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
    protected $silence = true;
    protected $defaultLayout;

    public function __construct($options = null)
    {
        parent::__construct($options);
        Config::get('app.debug') and $this->silence = false;
        $this->_viewsDir = Config::get('view.path');
        $this->_mainView = Config::get('view.top_level');
        $this->defaultLayout = Config::get('view.default_layout');
    }

    protected function _engineRender($engines, $viewPath, $silence, $mustClean, BackendInterface $cache = null)
    {
        $silence = $silence && $this->silence;
        parent::_engineRender($engines, $viewPath, $silence, $mustClean, $cache);
    }

    public static function getParam($key, $default = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return fnGet(static::$instance->_params, $key, $default, '.');
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
            return new static;
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
        $this->_layout = $this->defaultLayout;
        $this->_options = null;
        $this->_cache = null;
        $this->_renderLevel = static::LEVEL_MAIN_LAYOUT;
        $this->_cacheLevel = static::LEVEL_NO_RENDER;
        $this->_content = null;
        $this->_templatesBefore = null;
        $this->_templatesAfter = null;
        return $this;
    }
}
