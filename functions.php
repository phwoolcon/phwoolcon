<?php
use Phalcon\Di;
use Phalcon\Text;
use Phwoolcon\Config;
use Phwoolcon\I18n;
use Phwoolcon\Text as PhwoolconText;

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

function _e($string, $newLineToBr = true)
{
    return PhwoolconText::escapeHtml($string, $newLineToBr);
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
 * Copy dir, keep destination files, if exists
 *
 * @param string $source
 * @param string $destination
 */
function copyDirMerge($source, $destination)
{
    if (is_dir($source)) {
        is_dir($destination) or mkdir($destination, 0755, true);
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                copyDirMerge("$source/$file", "$destination/$file");
            }
        }
    } elseif (file_exists($source) && !file_exists($destination)) {
        copy($source, $destination);
    }
}

/**
 * Copy dir, override destination files, if exists
 *
 * @param string $source
 * @param string $destination
 */
function copyDirOverride($source, $destination)
{
    if (is_dir($source)) {
        is_dir($destination) or mkdir($destination, 0755, true);
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                copyDirOverride("$source/$file", "$destination/$file");
            }
        }
    } elseif (file_exists($source)) {
        copy($source, $destination);
    }
}

/**
 * Copy dir, delete entire destination dir first, if exists
 *
 * @param string $source
 * @param string $destination
 */
function copyDirReplace($source, $destination)
{
    if (file_exists($destination)) {
        removeDir($destination);
    }
    if (is_dir($source)) {
        mkdir($destination, 0755, true);
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                copyDirReplace("$source/$file", "$destination/$file");
            }
        }
    } elseif (file_exists($source)) {
        copy($source, $destination);
    }
}

/**
 * @param string $vendorDir
 * @return array
 */
function detectPhwoolconPackageFiles($vendorDir = null)
{
    $vendorDir or $vendorDir = $_SERVER['PHWOOLCON_ROOT_PATH'] . '/vendor';
    $packageFiles = glob($vendorDir . '/*/*/phwoolcon-package/phwoolcon-package-*.php');
    return $packageFiles;
}

/**
 * @param string   $filename
 * @param mixed    $array
 * @param callable $filter
 * @return int
 */
function fileSaveArray($filename, $array, callable $filter = null)
{
    $content = var_export($array, true);
    $filter and $content = call_user_func($filter, $content);
    $result = file_put_contents($filename, '<?php return ' . $content . ';');
    opcache_invalidate($filename, true);
    return $result;
}

function fileSaveInclude($target, array $includes)
{
    $content = '<?php' . PHP_EOL;
    foreach ($includes as $file) {
        if (Text::startsWith($file, $_SERVER['PHWOOLCON_ROOT_PATH'])) {
            $relativePath = str_replace($_SERVER['PHWOOLCON_ROOT_PATH'], '', $file);
            $content .= "include ROOT_PATH . '{$relativePath}';" . PHP_EOL;
        } // @codeCoverageIgnoreStart
        else {
            $content .= "include '{$file}';" . PHP_EOL;
        }
        // @codeCoverageIgnoreEnd
    }
    $result = file_put_contents($target, $content);
    opcache_invalidate($target, true);
    return $result;
}

/**
 * Safely get child value from an array or an object
 *
 * Usage:
 *
 * Assume you want to get value from a multidimensional array like: <code>$array = ['l1' => ['l2' => 'value']]</code>,<br>
 * then you can try following:
 *
 * <code>
 * $l1 = fnGet($array, 'l1'); // returns ['l2' => 'value']
 * $l2 = fnGet($array, 'l1.l2'); // returns 'value'
 * $undefined = fnGet($array, 'l3'); // returns null
 * </code>
 *
 * You can specify default value for undefined keys, and the key separator:
 *
 * <code>
 * $l2 = fnGet($array, 'l1/l2', null, '/'); // returns 'value'
 * $undefined = fnGet($array, 'l3', 'default value'); // returns 'default value'
 * </code>
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

/**
 * Return a relative path for destination relative to source
 *
 * @param string $source
 * @param string $destination
 * @return string
 */
function getRelativePath($source, $destination)
{
    $ds = DIRECTORY_SEPARATOR;
    // Process absolute paths only
    if ($source{0} == $ds && $destination{0} == $ds) {
        $pathEqualPos = 0;
        for ($pos = 0, $len = strlen($source); $pos < $len; ++$pos) {
            if ($source{$pos} != $destination{$pos}) {
                break;
            }
            $source{$pos} == $ds and $pathEqualPos = $pos;
        }
        $subSource = substr($source, $pathEqualPos + 1);
        $subDestination = substr($destination, $pathEqualPos + 1);
        $sourceDepth = substr_count(rtrim($subSource, $ds), $ds);
        if ($sourceDepth == 0) {
            return '.' . $ds . $subDestination;
        }
        return str_repeat('..' . $ds, $sourceDepth) . $subDestination;
    }
    return $destination;
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

function removeDir($dir)
{
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                removeDir("$dir/$file");
            }
        }
        rmdir($dir);
    } elseif (file_exists($dir) || is_link($dir)) {
        unlink($dir);
    }
}

function secureUrl($path, array $queries = [])
{
    return url($path, $queries, true);
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

/**
 * Return sorted and merged result of a given array, which contains sort orders as top level keys.
 * Values with smaller sort order will be overridden by bigger ones.
 *
 * Example:
 * <code>
 *  $array = [
 *      10 => [                 // 10 is a sort order
 *          'foo' => 'bar',     // Holds value 'bar' in key 'foo'
 *          'who' => 'me',
 *      ],
 *      20 => [                 // 20 is a bigger sort order
 *          'foo' => 'baz',     // This will override the key 'foo' with value 'baz'
 *          'hello' => 'world', // New values will be merged
 *      ],
 *  ];
 *  var_export($result = arraySortedMerge($array));
 * </code>
 *
 * Will produce:
 * <code>
 *  $result = [
 *      'foo' => 'baz',
 *      'who' => 'me',
 *      'hello' => 'world',
 *  ];
 * </code>
 *
 * @param array $array
 * @return array
 */
function arraySortedMerge(array $array)
{
    ksort($array);
    $mergedArray = [];
    foreach ($array as $item) {
        $mergedArray = array_merge($mergedArray, $item);
    }
    return $mergedArray;
}

function storagePath($path = null)
{
    return $_SERVER['PHWOOLCON_ROOT_PATH'] . '/storage' . ($path ? '/' . $path : '');
}

/**
 * Copy dir by symlink files, override destination files, if exists
 *
 * @param string $source
 * @param string $destination
 */
function symlinkDirOverride($source, $destination)
{
    if (is_dir($source)) {
        is_dir($destination) or mkdir($destination, 0755, true);
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                symlinkDirOverride("$source/$file", "$destination/$file");
            }
        }
    } elseif (is_file($source)) {
        is_file($destination) and unlink($destination);
        symlinkRelative($source, $destination);
    }
}

/**
 * Creates a symlink with relative path to source
 * On Windows, the file will be copied instead of symlink
 *
 * @param string $source
 * @param string $destination
 * @return bool
 */
function symlinkRelative($source, $destination)
{
    if ($targetDir = dirname($destination)) {
        is_dir($targetDir) or mkdir($targetDir, 0755, true);
    }
    // @codeCoverageIgnoreStart
    if (Text::startsWith(PHP_OS, 'WIN')) {
        return copy($source, $destination);
    }
    // @codeCoverageIgnoreEnd
    $cwd = getcwd();
    $relativePath = getRelativePath($destination, $source);
    chdir(dirname($destination));
    $result = symlink($relativePath, $destination);
    chdir($cwd);
    return (bool)$result;
}

function url($path, array $queries = [], $secure = null)
{
    // Store the variables which are almost unchanged between invocations as static
    /* @var \Phalcon\Http\Request $request */
    static $runningUnitTest, $config, $request, $baseDirs = [], $hostComponents;
    $runningUnitTest === null and $runningUnitTest = Config::runningUnitTest();
    $hostComponents === null and $hostComponents = parse_url(Config::get('app.url'));
    $config === null || $runningUnitTest === true and $config = [
        'enable_https' => Config::get('app.enable_https'),
        'secure_routes' => Config::get('app.secure_routes'),
        'host' => (isset($hostComponents['host']) ? $hostComponents['host'] :
                'localhost') . (isset($hostComponents['port']) ? ':' . $hostComponents['port'] : ''),
    ];
    $request === null and $request = Di::getDefault()['request'];

    if (isHttpUrl($path)) {
        return $path;
    }

    // Decide http or https
    $path = trim($path, '/');
    if ($config['enable_https']) {
        Text::startsWith($path, 'admin', false) and $secure = true;
        $secure === null && isset($config['secure_routes'][$path]) and $secure = $config['secure_routes'][$path];
        // TODO Detect https via proxy
        $secure === null and $secure = $request->getScheme() === 'https';
    } else {
        $secure = false;
    }
    $protocol = $secure ? 'https://' : 'http://';

    // Decide host
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $config['host'];

    // Decide base dir
    $scriptName = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
    if (isset($baseDirs[$scriptName])) {
        $base = $baseDirs[$scriptName];
    } else {
        $base = $scriptName;
        $base = trim(dirname($base), '/');
        $base and $base .= '/';
        $baseDirs[$scriptName] = $base;
    }
    $url = $protocol . $host . '/' . $base;

    // Apply path and queries
    $url .= $path;
    if ($queries) {
        $delimiter = strpos($path, '?') === false ? '?' : '&';
        $url .= $delimiter . http_build_query($queries);
    }
    return $url;
}

// @codeCoverageIgnoreStart

// OPCache workaround
if (!function_exists('opcache_invalidate')) {
    /**
     * (PHP 5 &gt;= 5.5.0, PECL ZendOpcache &gt;= 7.0.0 )<br/>
     * Invalidates a cached script
     * @link http://www.php.net/manual/en/function.opcache-invalidate.php
     * @param string $script <p>The path to the script being invalidated.</p>
     * @param bool $force [optional] <p> If set to <b>TRUE</b>, the script will be invalidated
     *                    regardless of whether invalidation is necessary.</p>
     * @return boolean
     * Returns <b>TRUE</b> if the opcode cache for <em>script</em> was
     * invalidated or if there was nothing to invalidate, or <b>FALSE</b> if the opcode
     * cache is disabled.
     */
    function opcache_invalidate($script, $force = false)
    {
        return true;
    }
}

if (!function_exists('opcache_reset')) {
    /**
     * (PHP 5 &gt;= 5.5.0, PECL ZendOpcache &gt;= 7.0.0 )<br/>
     * Resets the contents of the opcode cache
     * @link http://www.php.net/manual/en/function.opcache-reset.php
     * @return boolean
     * Returns <b>TRUE</b> if the opcode cache was reset, or <b>FALSE</b> if the opcode cache is disabled.
     */
    function opcache_reset()
    {
        return true;
    }
}

// Random Bytes workaround
if (!function_exists('random_bytes')) {
    function random_bytes($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}
// @codeCoverageIgnoreEnd
