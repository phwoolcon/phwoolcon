<?php
use Phwoolcon\Exception\NotFoundException;
use Phalcon\Di;

/**
 * Safely get child value from an array or an object
 *
 * Usage:
 * Assume you want to get value from a multidimensional array like: $array = ['l1' => ['l2' => 'value']],
 * then you can try following:
 * $l1 = fnGet($array, 'l1'); // returns ['l2' => 'value']
 * $l2 = fnGet($array, 'l1/l2'); // returns 'value'
 * $undefined = fnGet($array, 'l3'); // returns null
 *
 * You can specify default value for undefined keys, and the key separator:
 * $l2 = fnGet($array, 'l1.l2', null, '.'); // returns 'value'
 * $undefined = fnGet($array, 'l3', 'default value'); // returns 'default value'
 *
 * @param array|object $array     Subject array or object
 * @param              $key
 * @param mixed        $default   Default value if key not found in subject
 * @param string       $separator Key level separator, default '/'
 *
 * @return mixed
 */
function fnGet(&$array, $key, $default = null, $separator = '/')
{
    if (false === $subKeyPos = strpos($key, $separator)) {
        if (is_object($array)) {
            return property_exists($array, $key) ? $array->$key : $default;
        }
        return isset($array[$key]) ? $array[$key] : $default;
    } else {
        $firstKey = substr($key, 0, $subKeyPos);
        if (is_object($array)) {
            $tmp = property_exists($array, $firstKey) ? $array->$firstKey : null;
        } else {
            $tmp = isset($array[$firstKey]) ? $array[$firstKey] : null;
        }
        return fnGet($tmp, substr($key, $subKeyPos + 1), $default, $separator);
    }
}

/**
 * Show execution trace for debugging
 *
 * @param bool $exit  Set to true to exit after show trace.
 * @param bool $print Set to true to print trace
 *
 * @return string
 */
function showTrace($exit = true, $print = true)
{
    $e = new Exception;
    if ($print) {
        echo '<pre>', $e->getTraceAsString(), '</pre>';
    }
    if ($exit) {
        exit;
    }
    return $e->getTraceAsString();
}

function storagePath($path = null)
{
    return Di::getDefault()['ROOT_PATH'] . '/storage' . ($path ? '/' . $path : '');
}

function throw404Exception()
{
    throw new NotFoundException(json_encode([
        'error_code' => 404,
        'error_msg' => '404 Not Found',
    ]), 404, ['content-type' => 'application/json']);
}

function url($path, $queries = [], $secure = null)
{
    if (substr($path, 0, 2) == '//' || ($prefix = substr($path, 0, 7)) == 'http://' || $prefix == 'https:/') {
        return $path;
    }
    $secure === null and $secure = Di::getDefault()['request']->isSecureRequest();
    $protocol = $secure ? 'https://' : 'http://';
    $host = fnGet($_SERVER, 'HTTP_HOST');
    $base = $_SERVER['SCRIPT_NAME'];
    $base = trim(dirname($base), '/');
    $base and $base .= '/';
    $url = $protocol . $host . '/' . $base;
    $url .= $path;
    if ($queries && is_array($queries)) {
        $queries = http_build_query($queries);
    }
    $queries && is_string($queries) and $url .= '?' . str_replace('?', '', $queries);
    return $url;
}
