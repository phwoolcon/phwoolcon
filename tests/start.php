<?php

use Phalcon\Di\FactoryDefault;

error_reporting(-1);
$_SERVER['PHALCON_ENV'] = 'testing';

if (!extension_loaded('phalcon')) {
    echo $error = 'Extension "phalcon" not detected, please install or activate it.';
    throw new RuntimeException($error);
}

define('TEST_ROOT_PATH', __DIR__);

// The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
$di = new FactoryDefault();
$di->setShared('ROOT_PATH', function () {
    return TEST_ROOT_PATH;
});
$di->setShared('CONFIG_PATH', function () {
    static $configPath;
    $configPath or $configPath = TEST_ROOT_PATH . '/app/config';
    return $configPath;
});

// Register class loader
include __DIR__ . '/../vendor/autoload.php';
