<?php

namespace Phwoolcon\Controller;

use InvalidArgumentException;
use Phwoolcon\Log;
use Phwoolcon\Router;

/**
 * Class Api
 * @package Phwoolcon\Controller
 *
 * @method \Phalcon\Http\Response jsonReturn(array $array, $httpCode = 200, $contentType = 'application/json')
 */
trait Api
{
    protected $jsonApiContentType = 'application/vnd.api+json';
    protected $jsonApiVersion = ['version' => '1.0'];

    public function initialize()
    {
        Router::disableCsrfCheck();
        Router::disableSession();
    }

    public function missingMethod()
    {
        Router::throw404Exception(json_encode([
            'jsonapi' => $this->jsonApiVersion,
            'errors' => [
                [
                    'status' => 404,
                    'code' => 404,
                    'title' => '404 Not Found',
                ],
            ],
        ]), $this->jsonApiContentType);
    }

    /**
     * Returns JSON API data
     * @see http://jsonapi.org/format/#document-resource-objects
     *
     * @param array $data SHOULD contain `id` and `type`, MAY contain `attributes`, `relationships`, `links`
     * @param array $meta
     * @param array $extraData
     * @param int   $status
     * @return \Phalcon\Http\Response
     */
    public function jsonApiReturnData(array $data, array $meta = [], array $extraData = [], $status = 200)
    {
        $extraData['jsonapi'] = $this->jsonApiVersion;
        $extraData['data'] = $data;
        $meta and $extraData['meta'] = $meta;
        return $this->jsonReturn($extraData, $status, $this->jsonApiContentType);
    }

    /**
     * Returns JSON API error
     * @see http://jsonapi.org/format/#errors
     *
     * @param array $errors Each error SHOULD contain `code` and `title`,
     *                      MAY contain `id`, `status`, `links`, `detail`, `source`
     * @param array $meta
     * @param array $extraData
     * @param int   $status
     * @return \Phalcon\Http\Response
     */
    public function jsonApiReturnErrors(array $errors, array $meta = [], array $extraData = [], $status = 400)
    {
        foreach ($errors as &$error) {
            isset($error['code']) and $error['code'] = (string)$error['code'];
        }
        unset($error);
        $extraData['jsonapi'] = $this->jsonApiVersion;
        $extraData['errors'] = $errors;
        $meta and $extraData['meta'] = $meta;
        return $this->jsonReturn($extraData, $status, $this->jsonApiContentType);
    }

    public function jsonApiReturnMeta(array $meta, array $extraData = [], $status = 200)
    {
        $extraData['jsonapi'] = $this->jsonApiVersion;
        $extraData['meta'] = $meta;
        return $this->jsonReturn($extraData, $status, $this->jsonApiContentType);
    }
}
