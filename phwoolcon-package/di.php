<?php

use Phalcon\Version;
use Phwoolcon\Aliases;
use Phwoolcon\Cache;
use Phwoolcon\Config;
use Phwoolcon\Cookies;
use Phwoolcon\Db;
use Phwoolcon\DiFix;
use Phwoolcon\Events;
use Phwoolcon\I18n;
use Phwoolcon\Log;
use Phwoolcon\Mailer;
use Phwoolcon\Model\DynamicTrait\Loader as DynamicTrait;
use Phwoolcon\Queue;
use Phwoolcon\Router;
use Phwoolcon\Session;
use Phwoolcon\Util\Counter;
use Phwoolcon\View;

$_SERVER['PHWOOLCON_PHALCON_VERSION'] = Version::getId();

// PHP 7.2: ini_set(): Headers already sent. You cannot change the session module's ini settings at this time
ini_get('session.use_cookies') and ini_set('session.use_cookies', 0);
ini_get('session.cache_limiter') and ini_set('session.cache_limiter', '');

if (is_file($modelTraitFile = $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor/phwoolcon/model_traits.php')) {
    include $modelTraitFile;
}

Events::register($di);
DiFix::fix($di);
Db::register($di);
Cache::register($di);
Log::register($di);
Config::register($di);
Counter::register($di);
Aliases::register($di);
Router::register($di);
I18n::register($di);
Cookies::register($di);
Session::register($di);
View::register($di);
Queue::register($di);
DynamicTrait::register($di);
Mailer::register($di);

$loader->registerNamespaces(Config::get('app.autoload.namespaces', []), true);
if ($timezone = Config::get('app.timezone')) {
    date_default_timezone_set($timezone);
}
