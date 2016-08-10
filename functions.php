<?php
use Phalcon\Di;
use Phwoolcon\Config;
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
            $array =& $array[$key];
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

            $array =& $array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }
}

/**
 * Convert a decimal number into base62 string
 *
 * @param mixed $val Decimal value
 *
 * @return string Base 62 value
 */
function base62encode($val)
{
    $val = (int)abs($val);
    $base = 62;
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    do {
        $i = $val % $base;
        $str = $chars[$i] . $str;
        $val = ($val - $i) / $base;
    } while ($val > 0);
    return $str;
}

/**
 * @param string $filename
 * @param mixed  $array
 * @return int
 */
function fileSaveArray($filename, $array)
{
    return file_put_contents($filename, '<?php return ' . var_export($array, true) . ';');
}

/**
 * Safely get child value from an array or an object
 *
 * Usage:
 * Assume you want to get value from a multidimensional array like: $array = ['l1' => ['l2' => 'value']],
 * then you can try following:
 * $l1 = fnGet($array, 'l1'); // returns ['l2' => 'value']
 * $l2 = fnGet($array, 'l1.l2'); // returns 'value'
 * $undefined = fnGet($array, 'l3'); // returns null
 *
 * You can specify default value for undefined keys, and the key separator:
 * $l2 = fnGet($array, 'l1/l2', null, '/'); // returns 'value'
 * $undefined = fnGet($array, 'l3', 'default value'); // returns 'default value'
 *
 * @param array|object $array     Subject array or object
 * @param string       $key       Indicates the data element of the target value
 * @param mixed        $default   Default value if key not found in subject
 * @param string       $separator Key level separator, default '.'
 * @param bool         $hasObject Indicates that the subject may contains object, default false
 *
 * @return mixed
 */
function fnGet(&$array, $key, $default = null, $separator = '.', $hasObject = false)
{
    $tmp =& $array;
    if ($hasObject) {
        foreach (explode($separator, $key) as $subKey) {
            if (isset($tmp->$subKey)) {
                $tmp =& $tmp->$subKey;
            } else if (is_array($tmp) && isset($tmp[$subKey])) {
                $tmp =& $tmp[$subKey];
            } else {
                return $default;
            }
        }
        return $tmp;
    }
    foreach (explode($separator, $key) as $subKey) {
        if (isset($tmp[$subKey])) {
            $tmp =& $tmp[$subKey];
        } else {
            return $default;
        }
    }
    return $tmp;
}

function isHttpUrl($url)
{
    return substr($url, 0, 2) == '//' || ($prefix = substr($url, 0, 7)) == 'http://' || $prefix == 'https:/';
}

function migrationPath($path = null)
{
    return $_SERVER['PHWOOLCON_MIGRATION_PATH'] . ($path ? '/' . $path : '');
}

function price($amount, $currency = 'CNY')
{
    return I18n::formatPrice($amount, $currency);
}

if (!function_exists('random_bytes')) {
    function random_bytes($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}

/**
 * Show execution trace for debugging
 *
 * @param bool $exit  Set to true to exit after show trace.
 * @param bool $print Set to true to print trace
 *
 * @return string
 * @codeCoverageIgnore
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
    return $_SERVER['PHWOOLCON_ROOT_PATH'] . '/storage' . ($path ? '/' . $path : '');
}

function url($path, $queries = [], $secure = null)
{
    if (isHttpUrl($path)) {
        return $path;
    }
    $path = trim($path, '/');
    if (Config::get('app.enable_https')) {
        $secure === null && (null !== $configValue = Config::get('app.secure_routes.' . $path)) and $secure = $configValue;
        $secure === null and $secure = Di::getDefault()['request']->isSecureRequest();
    } else {
        $secure = false;
    }
    $protocol = $secure ? 'https://' : 'http://';
    $host = fnGet($_SERVER, 'HTTP_HOST') ?: parse_url(Config::get('app.url'), PHP_URL_HOST);
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
