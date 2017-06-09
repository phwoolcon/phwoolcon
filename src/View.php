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
use Phalcon\Mvc\View\Exception as ViewException;
use Phwoolcon\Assets\ResourceTrait;
use Phwoolcon\Daemon\ServiceAwareInterface;

class View extends PhalconView implements ServiceAwareInterface
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
    protected static $runningUnitTest = false;
    protected $config = [];
    protected $_theme;
    protected $_defaultTheme;
    protected $_loadedThemes = [];
    protected $_viewsDir;
    /**
     * @var Manager
     */
    public $assets;

    public function __construct($config = null)
    {
        parent::__construct($config['options']);
        $this->response = static::$di->getShared('response');
        $this->setViewsDir($this->_viewsDir = $config['path']);
        $this->_mainView = $config['top_level'];
        $this->_theme = $config['theme'];
        $this->_defaultTheme = 'default';
        $this->_layout = $config['default_layout'];
        $this->config = $config;
        $this->registerEngines($config['engines']);

        $basePath = $this->config['options']['assets_options']['base_path'];
        ResourceTrait::setBasePath($basePath);
        ResourceTrait::setRunningUnitTests(static::$runningUnitTest);
    }

    protected function _engineRender($engines, $viewPath, $silence, $mustClean, BackendInterface $cache = null)
    {
        $silence = $silence && !$this->config['debug'];
        $this->_options['debug_wrapper'] = $this->config['debug'] ?
            ($viewPath == $this->_mainView ? null : $this->getDebugWrapper($viewPath)) : null;
        $viewPath == $this->_mainView or $viewPath = $this->getAbsoluteViewPath($viewPath);
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
        $view->isAdmin() and $collectionName = 'admin-' . $collectionName;
        if ($useCache && isset(static::$cachedAssets[$collectionName])) {
            return static::$cachedAssets[$collectionName];
        }

        $view->loadAssets($view->config['assets']);
        $view->loadAssets($view->config['admin']['assets'], true);
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
        } // @codeCoverageIgnoreStart
        catch (Exception $e) {
            Log::exception($e);
        }
        // @codeCoverageIgnoreEnd
        $assets = ob_get_clean();
        if ($view->config['options']['assets_options']['apply_filter']) {
            $assets = str_replace(['http://', 'https://'], '//', $assets);
        }
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

    public static function generateIeHackBodyJs()
    {
        return static::assets('ie-hack-body-js');
    }

    public function getAbsoluteViewPath($view)
    {
        $path = $this->_viewsDir . $this->_theme . '/' . $view;
        return is_file($path) ? $path : $this->_viewsDir . $this->_defaultTheme . '/' . $view;
    }

    public static function getConfig($key = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return fnGet(static::$instance->config, $key);
    }

    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getCurrentTheme()
    {
        return $this->_theme;
    }

    /**
     * @param $viewPath
     * @return array
     * @codeCoverageIgnore
     */
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
        static::$instance or static::$instance = static::$di->getShared('view');
        $options = Events::fire('view:generatePhwoolconJsOptions', static::$instance, [
            'baseUrl' => url(''),
            'debug' => static::$instance->config['debug'],
        ]) ?: [];
        return $options;
    }

    public function isAdmin($flag = null)
    {
        if ($flag !== null) {
            $this->_options['is_admin'] = $flag = (bool)$flag;
            $this->_theme = $flag ? 'admin/' . $this->config['admin']['theme'] : $this->config['theme'];
            $this->_defaultTheme = $flag ? 'admin/default' : 'default';
        }
        return !empty($this->_options['is_admin']);
    }

    public function loadAssets($assets, $isAdmin = false)
    {
        $prefix = $isAdmin ? 'admin-' : '';
        if (isset($this->_loadedThemes[$prefix])) {
            return $this;
        }
        $this->_loadedThemes[$prefix] = true;
        $assetsOptions = $this->config['options']['assets_options'];
        $applyFilter = $assetsOptions['apply_filter'];

        // The base path, usually the public directory
        $basePath = $assetsOptions['base_path'];

        // The assets dir inside base path
        $resourcePath = '/' . $assetsOptions['assets_dir'] . '/';
        $compiledPath = '/' . $assetsOptions['compiled_dir'] . '/';
        foreach ($assets as $collectionName => $resources) {
            ksort($resources, SORT_STRING);
            $resourceType = substr($collectionName, strrpos($collectionName, '-') + 1);
            $collectionName = $prefix . $collectionName;
            $collection = $this->assets->collection($collectionName);
            $collection->setSourcePath($basePath);
            $contentHash = '';
            switch ($resourceType) {
                case 'css':
                    foreach ($resources as $item) {
                        $isLocal = !isHttpUrl($item);
                        $resource = new Css($isLocal ? $resourcePath . $item : $item, $isLocal);
                        $applyFilter and $contentHash = $resource->concatenateHash($contentHash);
                        $collection->add($resource);
                    }
                    $applyFilter and $collection->addFilter(new Cssmin());
                    break;
                case 'js':
                    foreach ($resources as $item) {
                        $isLocal = !isHttpUrl($item);
                        $resource = new Js($isLocal ? $resourcePath . $item : $item, $isLocal);
                        $applyFilter and $contentHash = $resource->concatenateHash($contentHash);
                        $collection->add($resource);
                    }
                    $applyFilter and $collection->addFilter(new Jsmin());
                    break;
            }
            $targetUri = $compiledPath . substr($collectionName, 0, -1 - strlen($resourceType));
            $contentHash and $targetUri .= '.' . $contentHash;
            $targetUri .= '.' . $resourceType;
            $collection->setTargetPath($basePath . $targetUri)
                ->setTargetUri(url($targetUri));
        }
        return $this;
    }

    public static function make($path, $file, $params = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        return static::$instance->render($path, $file, $params)->getContent();
    }

    public static function noFooter($flag = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        $flag === null or static::$instance->_options['no_footer'] = (bool)$flag;
        return !empty(static::$instance->_options['no_footer']);
    }

    public static function noHeader($flag = null)
    {
        static::$instance or static::$instance = static::$di->getShared('view');
        $flag === null or static::$instance->_options['no_header'] = (bool)$flag;
        return !empty(static::$instance->_options['no_header']);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        static::$runningUnitTest = Config::runningUnitTest();
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
        } // @codeCoverageIgnoreStart
        catch (ViewException $e) {
            Log::exception($e);
            return false;
        } catch (Exception $e) {
            throw $e;
        }
        // @codeCoverageIgnoreEnd
    }

    public function reset()
    {
        $this->_disabled = false;
        $this->_options = $this->config['options'];
        $this->_theme = $this->config['theme'];
        $this->_defaultTheme = 'default';
        $this->_layout = $this->config['default_layout'];
        $this->_cache = null;
        $this->_renderLevel = static::LEVEL_MAIN_LAYOUT;
        $this->_cacheLevel = static::LEVEL_NO_RENDER;
        $this->_content = null;
        $this->_templatesBefore = [];
        $this->_templatesAfter = [];
        $this->_params = [];
        return $this;
    }

    public function setContent($content)
    {
        // @codeCoverageIgnoreStart
        if (isset($this->_options['debug_wrapper'])) {
            $wrapper = $this->_options['debug_wrapper'];
            $this->_content = $wrapper[0] . $content . $wrapper[1];
        } // @codeCoverageIgnoreEnd
        else {
            $this->_content = $content;
        }
        return $this;
    }

    public function setParams(array $params)
    {
        $this->_params = $params;
    }
}
