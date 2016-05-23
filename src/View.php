<?php
namespace Phwoolcon;

use Exception;
use Phalcon\Assets\Filters\Cssmin;
use Phalcon\Assets\Filters\Jsmin;
use Phalcon\Assets\Manager;
use Phwoolcon\Assets\Resource\Css;
use Phwoolcon\Assets\Resource\Js;
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
    protected static $cachedAssets = [];
    protected $config = [];
    protected $_theme;
    protected $_loadedThemes = [];
    /**
     * @var Manager
     */
    public $assets;

    public function __construct($config = null)
    {
        parent::__construct($config['options']);
        $this->response = static::$di->getShared('response');
        $this->setViewsDir($config['path']);
        $this->_mainView = $config['top_level'];
        $this->_theme = $config['theme'];
        $this->_layout = $config['default_layout'];
        $this->config = $config;
        $this->registerEngines($config['engines']);
    }

    protected function _engineRender($engines, $viewPath, $silence, $mustClean, BackendInterface $cache = null)
    {
        $silence = $silence && !$this->config['debug'];
        $this->config['debug'] and $this->_options['debug_wrapper'] = ($viewPath == $this->_mainView ? false : $this->getDebugWrapper($viewPath));
        $viewPath == $this->_mainView or $viewPath = trim($this->_theme . '/' . $viewPath, '/');
        parent::_engineRender($engines, $viewPath, $silence, $mustClean, $cache);
    }

    public static function assets($collectionName)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        $view = static::$instance;
        $useCache = $view->config['options']['assets_options']['cache_assets'];
        if (!$view->assets) {
            $view->assets = static::$di->getShared('assets');
            $useCache and static::$cachedAssets = Cache::get('assets');
        }
        $type = substr($collectionName, strrpos($collectionName, '-') + 1);
        $collectionName = $view->_theme . '-' . $collectionName;
        $view->isAdmin() and $collectionName = 'admin-' . $collectionName;
        if ($useCache && isset(static::$cachedAssets[$collectionName])) {
            return static::$cachedAssets[$collectionName];
        }

        $view->loadAssets($view->config['assets'], $view->_theme);
        $view->loadAssets($view->config['admin']['assets'], $view->_theme, true);
        ob_start();
        try {
            switch ($type) {
                case 'js':
                    $view->assets->outputJs($collectionName);
                    break;
                case 'css':
                    $view->assets->outputCss($collectionName);
                    break;
            }
        } catch (Exception $e) {
            Log::exception($e);
        }
        $assets = ob_get_clean();
        static::$cachedAssets[$collectionName] = $assets;
        $useCache and Cache::set('assets', static::$cachedAssets);
        return $assets;
    }

    public static function clearAssetsCache()
    {
        static::$cachedAssets = [];
        Cache::delete('assets');
    }

    public static function generateBodyJs()
    {
        return static::assets('body-js');
    }

    public static function generateHeadCss()
    {
        return static::assets('head-css');
    }

    public static function generateHeadJs()
    {
        return static::assets('head-js');
    }

    public static function generateIeHack()
    {
        return static::assets('ie-hack-css') . static::assets('ie-hack-js');
    }

    public function getAbsoluteViewPath($view)
    {
        return $this->_viewsDir . $this->_theme . '/' . $view;
    }

    public static function getConfig($key = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return fnGet(static::$instance->config, $key);
    }

    public function getCurrentTheme()
    {
        return $this->_theme;
    }

    public function getDebugWrapper($viewPath)
    {
        $viewPath = trim($this->_theme . '/' . $viewPath, '/');
        return ["<!-- [{$viewPath} -->\n", "<!-- {$viewPath}] -->\n"];
    }

    public static function getPageDescription()
    {
        return static::getParam('page_description');
    }

    public static function getPageKeywords()
    {
        $keywords = static::getParam('page_keywords');
        is_array($keywords) and $keywords = implode(',', $keywords);
        return $keywords;
    }

    public static function getPageLanguage()
    {
        return strtr(static::getParam('page_language', I18n::getCurrentLocale()), ['_' => '-']);
    }

    public static function getPageTitle()
    {
        $title = static::getParam('page_title');
        is_array($title) and $title = implode(static::getConfig('title_separator'), array_reverse($title));
        return $title;
    }

    public static function getParam($key, $default = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return fnGet(static::$instance->_params, $key, $default, '.');
    }

    public static function getPhwoolconJsOptions()
    {
        $options = [
            'locale' => I18n::getCurrentLocale(),
            'cookies' => [
                'domain' => Config::get('cookies.domain'),
                'path' => Config::get('cookies.path'),
            ],
        ];
        return $options;
    }

    public function isAdmin($flag = null)
    {
        if ($flag !== null) {
            $this->_options['is_admin'] = $flag = (bool)$flag;
            $this->_theme = $flag ? $this->config['admin']['theme'] : $this->config['theme'];
        }
        return !empty(static::$instance->_options['is_admin']);
    }

    public function loadAssets($assets, $theme, $isAdmin = false)
    {
        $prefix = $isAdmin ? 'admin-' : '';
        if (isset($this->_loadedThemes[$prefix . $theme])) {
            return $this;
        }
        $this->_loadedThemes[$prefix . $theme] = true;
        $applyFilter = $this->config['options']['assets_options']['apply_filter'];
        $basePath = $this->config['options']['assets_options']['base_path'];
        $assetsDir = '/' . $this->config['options']['assets_options']['assets_dir'] . '/';
        $resourcePath = $assetsDir . ($isAdmin ? 'admin/' . $theme : $theme) . '/';
        $compiledPath = $assetsDir . 'compiled/';
        foreach ($assets as $collectionName => $resources) {
            $resourceType = substr($collectionName, strrpos($collectionName, '-') + 1);
            $collectionName = $theme . '-' . $collectionName;
            $collectionName = $prefix . $collectionName;
            $collection = $this->assets->collection($collectionName);
            $collection->setSourcePath($basePath)
                ->setTargetPath($basePath . $targetUri = $compiledPath . $collectionName . '.' . $resourceType)
                ->setTargetUri(url($targetUri));
            switch ($resourceType) {
                case 'css':
                    foreach ($resources as $item) {
                        $isLocal = !isHttpUrl($item);
                        $resource = new Css($isLocal ? $resourcePath . $item : $item, $isLocal);
                        $collection->add($resource);
                    }
                    $applyFilter and $collection->addFilter(new Cssmin());
                    break;
                case 'js':
                    foreach ($resources as $item) {
                        $isLocal = !isHttpUrl($item);
                        $resource = new Js($isLocal ? $resourcePath . $item : $item, $isLocal);
                        $collection->add($resource);
                    }
                    $applyFilter and $collection->addFilter(new Jsmin());
                    break;
            }
        }
        return $this;
    }

    public static function make($path, $file, $params = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return static::$instance->reset()->render($path, $file, $params)->getContent();
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
            $this->start();
            $result = parent::render($controllerName, $actionName, $params);
            $this->finish();
            $this->response->setContent($this->getContent());
            return $result;
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
        $this->_params = [];
        return $this;
    }

    public function setContent($content)
    {
        if (isset($this->_options['debug_wrapper'])) {
            $wrapper = $this->_options['debug_wrapper'];
            $this->_content = $wrapper[0] . $content . $wrapper[1];
        } else {
            $this->_content = $content;
        }
        return $this;
    }
}
