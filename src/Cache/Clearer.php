<?php
namespace Phwoolcon\Cache;

use ArrayIterator;
use Phwoolcon\Cache;
use Phwoolcon\Config;
use Phwoolcon\Db;
use Phwoolcon\Events;
use Phwoolcon\I18n;
use Phwoolcon\Router;
use Phwoolcon\View;

class Clearer
{
    const TYPE_ASSETS = 'assets';
    const TYPE_CONFIG = 'config';
    const TYPE_LOCALE = 'locale';
    const TYPE_META = 'meta';
    const TYPE_ROUTES = 'routes';

    protected static $types = [
        self::TYPE_CONFIG => 'Clear config cache',
        self::TYPE_META => 'Clear model metadata',
        self::TYPE_LOCALE => 'Clear locale cache',
        self::TYPE_ASSETS => 'Clear assets cache',
        self::TYPE_ROUTES => 'Clear routes cache',
    ];

    public static function clear($types = null)
    {
        $types = array_flip((array)$types);
        $clearAll = true;
        $messages = new ArrayIterator();
        // @codeCoverageIgnoreStart
        if (isset($types['config'])) {
            $clearAll = false;
            Config::clearCache();
            $messages[] = 'Config cache cleared.';
        }
        // @codeCoverageIgnoreEnd
        if (isset($types['meta'])) {
            $clearAll = false;
            Db::clearMetadata();
            $messages[] = 'Model metadata cleared.';
        }
        if (isset($types['locale'])) {
            $clearAll = false;
            I18n::clearCache();
            $messages[] = 'Locale cache cleared.';
        }
        if (isset($types['assets'])) {
            $clearAll = false;
            View::clearAssetsCache();
            $messages[] = 'Assets cache cleared.';
        }
        if (isset($types['routes'])) {
            $clearAll = false;
            Router::clearCache();
            $messages[] = 'Routes cache cleared.';
        }
        if ($clearAll) {
            Cache::flush();
            Config::clearCache();
            Router::clearCache();
            $messages[] = 'Cache cleared.';
        }
        Events::fire('cache:after_clear', $messages, $messages);
        return $messages;
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * @param array $types
     * @codeCoverageIgnore
     */
    public static function setTypes($types)
    {
        self::$types = $types;
    }
}
