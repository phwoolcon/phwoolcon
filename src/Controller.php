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
    const BROWSER_CACHE_ETAG = 'etag';
    const BROWSER_CACHE_CONTENT = 'content';

    protected $pageTitles = [];

    public function addPageTitle($title)
    {
        $this->pageTitles[] = $title;
        return $this;
    }

    public function getBrowserCache($pageId = null, $type = null)
    {
        $pageId or $pageId = $this->request->getURI();
        $cacheKey = md5($pageId);
        switch ($type) {
            case (static::BROWSER_CACHE_ETAG):
                return Cache::get('fpc-etag-' . $cacheKey);
            case (static::BROWSER_CACHE_CONTENT):
                return Cache::get('fpc-content-' . $cacheKey);
        }
        return [
            'etag' => Cache::get('fpc-etag-' . $cacheKey),
            'content' => Cache::get('fpc-content-' . $cacheKey),
        ];
    }

    public function getContentEtag(&$content)
    {
        return 'W/' . dechex(crc32($content));
    }

    /**
     * Q: Why make the `php://input` encapsulation?
     * A: I want to use it in service mode, which is impossible to pass data via `php://input` between processes.
     *    This is not exactly the same as the Phalcon's implementation.
     * @see \Phalcon\Http\Request::getRawBody()
     * @return string
     * @codeCoverageIgnore
     */
    protected function getRawPhpInput()
    {
        isset($_SERVER['RAW_PHP_INPUT']) or $_SERVER['RAW_PHP_INPUT'] = file_get_contents('php://input');
        return $_SERVER['RAW_PHP_INPUT'];
    }

    public function initialize()
    {
        $this->pageTitles = [__(Config::get('view.title_suffix'))];
        isset($this->view) and $this->view->reset();
    }

    public function render($path, $view, array $params = [])
    {
        $params['page_title'] = $this->pageTitles;
        return $this->view->render($path, $view, $params);
    }

    public function setBrowserCache($pageId = null, $type = null, $ttl = Cache::TTL_ONE_WEEK)
    {
        $pageId or $pageId = $this->request->getURI();
        $cacheKey = md5($pageId);
        $content = $this->response->getContent();
        $eTag = $this->getContentEtag($content);
        switch ($type) {
            case (static::BROWSER_CACHE_ETAG):
                Cache::set('fpc-etag-' . $cacheKey, $eTag, $ttl);
                break;
            case (static::BROWSER_CACHE_CONTENT):
                Cache::set('fpc-content-' . $cacheKey, $content, $ttl);
                break;
            default:
                Cache::set('fpc-etag-' . $cacheKey, $eTag, $ttl);
                Cache::set('fpc-content-' . $cacheKey, $content, $ttl);
                break;
        }
        $this->setBrowserCacheHeaders($eTag, $ttl);
        return $this;
    }

    public function setBrowserCacheHeaders($eTag, $ttl = Cache::TTL_ONE_WEEK)
    {
        $this->response->setHeader('Expires', gmdate(DateTime::RFC2616, time() + $ttl))
            ->setHeader('Cache-Control', 'public, max-age=' . $ttl)
            ->setHeader('Pragma', 'public')
            ->setHeader('Last-Modified', gmdate(DateTime::RFC2616))
            ->setEtag($eTag);
    }

    /**
     * response json content
     *
     * @param array  $array
     * @param int    $httpCode
     * @param string $contentType
     * @return \Phalcon\Http\Response
     */
    protected function jsonReturn(array $array, $httpCode = 200, $contentType = 'application/json')
    {
        return $this->response->setHeader('Content-Type', $contentType)
            ->setStatusCode($httpCode)
            ->setJsonContent($array);
    }

    /**
     * redirect url
     *
     * @param null $location
     * @param int  $statusCode
     * @return \Phalcon\Http\Response
     */
    protected function redirect($location = null, $statusCode = 302)
    {
        return $this->response->redirect(url($location), true, $statusCode);
    }

    /**
     * Get input from request
     *
     * @param string $key
     * @param mixed  $defaultValue
     * @return mixed
     */
    protected function input($key = null, $defaultValue = null)
    {
        return is_null($key) ? $_REQUEST : fnGet($_REQUEST, $key, $defaultValue);
    }
}
