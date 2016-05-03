<?php
use Phalcon\Di;
use Phwoolcon\I18n;

/**
 * Translate
 *
 * @param string     $string
 * @param array|null $params
 * @param string     $package
 *
 * @return string
 */
function __($string, array $params = null, $package = null)
{
    return I18n::translate($string, $params, $package);
}

if (!function_exists('array_forget')) {
    /**
     * Remove an array item from a given array using "dot" notation.
     *
     * @param array  $array
     * @param string $key
     * @param string $separator
     * @return void
     */
    function array_forget(&$array, $key, $separator = '.')
    {
        $keys = explode($separator, $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key]) || !is_array($array[$key])) {
                return;
            }
            $array = &$array[$key];
        }
        unset($array[array_shift($keys)]);
    }
}

if (!function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     * @param string $separator
     * @return array
     */
    function array_set(&$array, $key, $value, $separator = '.')
    {
        if (is_null($key)) {
            return $array = $value;
        }
        $keys = explode($separator, $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }
}

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
        if ($tmp === null) {
            return $default;
        }
        return fnGet($tmp, substr($key, $subKeyPos + 1), $default, $separator);
    }
}

function migrationPath($path = null)
{
    return Di::getDefault()['MIGRATION_PATH'] . ($path ? '/' . $path : '');
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
    $path{0} == '/' and $path = substr($path, 1);
    $url .= $path;
    if ($queries && is_array($queries)) {
        $queries = http_build_query($queries);
    }
    $queries && is_string($queries) and $url .= '?' . str_replace('?', '', $queries);
    return $url;
}
