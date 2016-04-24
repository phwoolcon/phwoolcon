<?php
namespace Phwoolcon;

use Phalcon\Di;

class Lang
{
    protected static $lang = [];

    /**
     * @param $key
     * @return string
     */
    public static function get($key)
    {
        $languageConfig = Config::get('app.language');
        if (fnGet($languageConfig, 'use_browser')) {
            /* @var $request \Phalcon\Http\Request */
            $request = Di::getDefault()->getShared('request');
            $language = $request->getBestLanguage();
        } else {
            $language = fnGet($languageConfig, 'locale');
        }

        if (!isset(self::$lang[$language])) {
            if (file_exists($path = Di::getDefault()['ROOT_PATH'] . "/app/languages/" . $language . ".php")) {
                self::$lang[$language] = require $path;
            }
        }
        return isset(self::$lang[$language][$key]) ? self::$lang[$language][$key] : $key;
    }

}
