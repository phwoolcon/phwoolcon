<?php
namespace Phwoolcon;

use Phalcon\Mvc\Controller as PhalconController;

/**
 * Class Controller
 * @package Phwoolcon
 *
 * @property \Phalcon\Http\Request $request
 * @property Session|Session\AdapterTrait $session
 * @property View $view
 */
abstract class Controller extends PhalconController
{
    protected $pageTitles = [];

    public function addPageTitle($title)
    {
        $this->pageTitles[] = $title;
    }

    public function initialize()
    {
        $this->pageTitles = [__(Config::get('view.title_suffix'))];
        $this->view->reset();
    }

    public function render($path, $view, array $params = [])
    {
        $params['page_title'] = $this->pageTitles;
        $this->view->render($path, $view, $params);
    }

    /**
     * response json content
     *
     * @param array $array
     * @param int   $httpCode
     * @return \Phalcon\Http\Response
     */
    protected function jsonReturn(array $array, $httpCode = 200)
    {
        return $this->response->setHeader("Content-Type", "application/json")
            ->setStatusCode($httpCode)
            ->setJsonContent($array);
    }

    /**
     * set cookie
     *
     * @param        $name
     * @param null   $value
     * @param int    $expire
     * @param string $path
     * @param null   $secure
     * @param null   $domain
     * @param null   $httpOnly
     * @return \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface
     */
    protected function cookie(
        $name,
        $value = null,
        $expire = 0,
        $path = "/",
        $secure = null,
        $domain = null,
        $httpOnly = null
    ) {
        return $this->cookies->set($name, $value, $expire, $path, $secure, $domain, $httpOnly);
    }

    /**
     * set session use default session adapter
     *
     * @param $index
     * @param $value
     */
    protected function session($index, $value)
    {
        $this->session->set($index, $value);
    }

    /**
     * add content
     *
     * @param $content
     */
    protected function content($content)
    {
        $this->response->appendContent($content);
    }

    /**
     * stop application and return content to client
     *
     * @param int $httpCode
     * @return \Phalcon\Http\ResponseInterface
     */
    protected function response($httpCode = 200)
    {
        return $this->response->setStatusCode($httpCode);
    }

    /**
     * redirect url
     *
     * @param null $location
     * @param bool $externalRedirect
     * @param int  $statusCode
     * @return \Phalcon\Http\Response
     */
    protected function redirect($location = null, $statusCode = 302, $externalRedirect = false)
    {
        return $this->response->redirect(url($location), $externalRedirect, $statusCode);
    }

    /**
     * assign vars into template
     *
     * @link https://docs.phalconphp.com/zh/latest/reference/volt.html
     * @param      $name
     * @param null $value
     * @return \Phalcon\Mvc\View
     */
    protected function assign($name, $value = null)
    {
        if (is_array($name) && $value === null) {
            return $this->view->setVars($name);
        } else {
            return $this->view->setVar($name, $value);
        }
    }

    /**
     * get input from request
     *
     * @param null $name
     * @param null $filters
     * @param null $defaultValue
     * @return mixed
     */
    protected function input($name = null, $filters = null, $defaultValue = null)
    {
        if (strpos($name, "/") !== false) {
            list($method, $name) = explode("/", $name);
            if (method_exists($this->request, $realMethod = 'get' . ucfirst(strtolower($method)))) {
                return $this->request->$realMethod($name, $filters, $defaultValue);
            }
        }
        return $this->request->get($name, $filters, $defaultValue);
    }

    /**
     * check if request has the specify input
     *
     * @param $name
     * @return bool
     */
    protected function has($name)
    {
        if (strpos($name, "/") !== false) {
            list($method, $name) = explode("/", $name);
            if (method_exists($this->request, $realMethod = 'has' . ucfirst(strtolower($method)))) {
                return $this->request->$realMethod($name);
            }
        }
        return $this->request->has($name);
    }
}
