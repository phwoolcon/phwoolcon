<?php
namespace Phwoolcon;

use Phalcon\DiInterface;
use Phalcon\Mvc\View as PhalconView;
use Phalcon\Mvc\View\Engine\Volt;

class View
{
    public static function register(DiInterface $di)
    {
        $viewConfig = Config::get('view');
        $di->set('voltService', function ($view, $di) use ($viewConfig) {
            $volt = new Volt($view, $di);
            is_dir($viewConfig['volt']['compiledPath']) or mkdir($viewConfig['volt']['compiledPath']);
            $volt->setOptions($viewConfig['volt']);

            //自定义 volt 模板方法
            $compiler = $volt->getCompiler();
            //多语言支持
            $compiler->addFunction('lang', 'lang');

            return $volt;
        });

        // Register Volt as template engine
        $di->set('view', function () use ($viewConfig) {
            $view = new PhalconView();
            $view->setViewsDir($viewConfig['path']);
            $view->registerEngines(
                [
                    $viewConfig['extension'] => 'voltService',
                ]
            );
            return $view;
        });
    }
}
