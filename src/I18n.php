<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Translate\Adapter;

class I18n extends Adapter
{
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var static
     */
    protected static $instance;
    protected $locale = [];
    protected $localePath;
    protected $defaultLocale;
    protected $currentLocale;
    protected $multiLocale = false;
    protected $detectClientLocale = false;
    /**
     * @var \Phalcon\Http\Request
     */
    protected $request;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->multiLocale = Config::get('multi_locale');
        $this->detectClientLocale = Config::get('i18n.detect_client_locale');
        $this->defaultLocale = $this->currentLocale = Config::get('i18n.default_locale');
        $this->localePath = Config::get('i18n.locale_path');
        $this->loadLocale($this->defaultLocale);
        $this->_reset();
    }

    protected function _reset()
    {
        if (!$this->multiLocale) {
            return;
        }
        if ($locale = Session::get('current_locale')) {
            $this->loadLocale($this->currentLocale = $locale);
            return;
        }
        if ($this->detectClientLocale) {
            $this->request or $this->request = static::$di->getShared('request');
            $this->_setLocale($this->request->getBestLanguage());
        }
    }

    protected function _setLocale($locale)
    {
        if (strpos($locale, '..') || !is_dir($this->localePath . '/' . $locale)) {
            $locale = $this->defaultLocale;
        }
        Session::set('current_locale', $this->currentLocale = $locale);
        $this->loadLocale($locale);
    }

    public function loadLocale($locale, $force = false)
    {
        if (($useCache = !$force) && isset($this->locale[$locale])) {
            return $this;
        }
        if (($cached = Cache::get($cacheKey = 'locale.' . $locale)) && $useCache) {
            $this->locale[$locale] = $cached;
            return $this;
        }
        $packages = [];
        $combined = [];
        foreach (glob($this->localePath . '/' . $this->defaultLocale . '/*.php') as $file) {
            $package = pathinfo($file, PATHINFO_FILENAME);
            $combined = array_merge($combined, $packages[$package] = include $file);
        }
        Cache::set($cacheKey, $this->locale[$locale] = compact('combined', 'packages'));
        return $this;
    }

    public function query($string, $params = null, $package = null)
    {
        if ($package && isset($this->locale[$this->currentLocale][$package][$string])) {
            $translation = $this->locale[$this->currentLocale][$package][$string];
        } else if (isset($this->locale[$this->currentLocale]['combined'][$string])) {
            $translation = $this->locale[$this->currentLocale]['combined'][$string];
        } else {
            $translation = $string;
        }
        return $this->replacePlaceholders($translation, $params);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->setShared('i18n', function () {
            return new static;
        });
    }

    public static function reset()
    {
        static::$instance or static::$instance = static::$di->getShared('i18n');
        static::_reset();
    }

    public static function setLocale($locale)
    {
        static::$instance or static::$instance = static::$di->getShared('i18n');
        static::_setLocale($locale);
    }

    public static function translate($string, array $params = null, $package = null)
    {
        static::$instance or static::$instance = static::$di->getShared('i18n');
        return static::$instance->query($string, $params, $package);
    }
}
