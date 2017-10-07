<?php

namespace Phwoolcon\Http;

use Phalcon\Di;
use Phwoolcon\Config;
use Phwoolcon\Exception\HttpClientException;

class Client
{
    protected static $componentName = 'http-client';
    /**
     * @var Di
     */
    protected static $di;
    /**
     * @var static
     */
    protected static $instance;

    protected $lastRequest;

    /**
     * @var string|null
     */
    protected $lastResponse;
    protected $lastResponseCode;
    protected $lastResponseHeaders;
    protected $lastCurlInfo;

    protected $options = [
        'connect_time_out' => 10,
        'time_out'         => 10,
        'verify_ssl'       => true,
        'user_agent'       => 'Phwoolcon HTTP Client; +https://github.com/phwoolcon',

        /*
         * 'host:port', e.g.: '127.0.0.1:8080'
         */
        'proxy'            => null,

        /*
         * Custom DNS: array of 'host:port:ip', e.g.:
         * ['www.example.com:443:172.16.1.1', 'abc.example.com:80:172.16.1.1']
         */
        'custom_dns'       => [],

        /*
         * Additional cURL options
         */
        'curl_options'     => [],
    ];

    public function __construct(array $options = [])
    {
        $this->options = array_replace($this->options, $options);
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove(static::$componentName);
        static::$instance = null;
        $di->setShared(static::$componentName, function () {
            return new static(Config::get(static::$componentName, []));
        });
    }

    public static function getInstance()
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance;
    }

    /**
     * @param string       $url
     * @param array|string $data
     * @param array        $headers
     * @return string|null
     * @codeCoverageIgnore
     */
    public static function delete($url, $data = '', $headers = [])
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance->sendRequest($url, $data, 'DELETE', $headers);
    }

    /**
     * @param string       $url
     * @param array|string $data
     * @param array        $headers
     * @return string|null
     */
    public static function get($url, $data = '', $headers = [])
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance->sendRequest($url, $data, 'GET', $headers);
    }

    /**
     * @param string       $url
     * @param array|string $data
     * @param array        $headers
     * @return string|null
     */
    public static function head($url, $data = '', $headers = [])
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance->sendRequest($url, $data, 'HEAD', $headers);
    }

    /**
     * @param string       $url
     * @param array|string $data
     * @param array        $headers
     * @return string|null
     */
    public static function post($url, $data = '', $headers = [])
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance->sendRequest($url, $data, 'POST', $headers);
    }

    /**
     * @param string       $url
     * @param array|string $data
     * @param array        $headers
     * @return string|null
     * @codeCoverageIgnore
     */
    public static function put($url, $data = '', $headers = [])
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance->sendRequest($url, $data, 'PUT', $headers);
    }

    /**
     * @param string       $url
     * @param array|string $data
     * @param string       $method
     * @param array        $headers
     * @return string|null
     */
    public static function request($url, $data = '', $method = 'GET', $headers = [])
    {
        static::$instance or static::$instance = static::$di->getShared(static::$componentName);
        return static::$instance->sendRequest($url, $data, $method, $headers);
    }

    /**
     * @return array|null
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return string|null
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return int
     */
    public function getLastResponseCode()
    {
        return $this->lastResponseCode;
    }

    /**
     * @return array|null
     */
    public function getLastCurlInfo()
    {
        return $this->lastCurlInfo;
    }

    /**
     * @return array
     */
    public function getLastResponseHeaders()
    {
        if (!is_array($this->lastResponseHeaders)) {
            $headers = [];
            foreach (explode("\r\n", $this->lastResponseHeaders) as $row) {
                if (!$row) {
                    continue;
                }
                $parts = explode(':', $row, 2);
                if (!isset($parts[1])) {
                    continue;
                }
                $headers[strtolower(trim($parts[0]))] = trim($parts[1]);
            }
            $this->lastResponseHeaders = $headers;
        }
        return $this->lastResponseHeaders;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return static
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    protected function sendRequest($url, $data = '', $method = 'GET', $headers = [])
    {
        $method = strtoupper($method);
        $data = is_array($data) ? http_build_query($data) : (string)$data;
        $hasData = isset($data{0});

        $this->lastResponseCode = 0;
        $this->lastResponse = $this->lastResponseHeaders = $this->lastCurlInfo = null;
        $this->lastRequest = compact('url', 'data', 'method', 'headers');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER         => 1,
            CURLOPT_TIMEOUT        => $this->options['time_out'],
            CURLOPT_USERAGENT      => $this->options['user_agent'],
            CURLOPT_CONNECTTIMEOUT => $this->options['connect_time_out'],
            CURLOPT_SSL_VERIFYPEER => $this->options['verify_ssl'],
            CURLOPT_SSL_VERIFYHOST => $this->options['verify_ssl'] ? 2 : 0,
            CURLOPT_HTTPHEADER     => $headers,
        ]);

        $this->options['custom_dns'] and curl_setopt($ch, CURLOPT_RESOLVE, $this->options['custom_dns']);
        $this->options['proxy'] and curl_setopt($ch, CURLOPT_PROXY, $this->options['proxy']);
        $this->options['curl_options'] and curl_setopt_array($ch, $this->options['curl_options']);

        switch ($method) {
            case 'HEAD':
                curl_setopt($ch, CURLOPT_NOBODY, true);
            // No break here
            case 'GET':
                $hasData and $url .= (strpos($url, '?') === false ? '?' : '&') . $data;
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                $hasData and curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                $hasData and curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
        }
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        $this->lastCurlInfo = $curlInfo = curl_getinfo($ch);
        if ($errNo = curl_errno($ch)) {
            $errMsg = 'cURL error (' . $errNo . '): "' . curl_error($ch) . '", request: ' .
                var_export($this->lastRequest, true);
            curl_close($ch);
            throw new HttpClientException($errMsg, $errNo);
        }
        curl_close($ch);

        $this->lastResponseCode = $curlInfo['http_code'];
        $headerSize = $curlInfo['header_size'];
        $this->lastResponseHeaders = substr($response, 0, $headerSize);

        $this->lastResponse = substr($response, $headerSize);
        return $this->lastResponse;
    }
}
