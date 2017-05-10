<?php
namespace Phwoolcon;

use Phalcon\Text as PhalconText;

class Text extends PhalconText
{

    /**
     * @param string $string
     * @param int    $length
     * @param string $suffix
     * @return string
     * @codeCoverageIgnore
     */
    public static function ellipsis($string, $length, $suffix = '...')
    {
        return mb_strlen($string) > $length ? mb_substr($string, 0, $length - mb_strlen($suffix)) . $suffix : $string;
    }

    public static function escapeHtml($string, $newLineToBr = true)
    {
        $result = htmlspecialchars($string);
        return $newLineToBr ? nl2br($result) : $result;
    }

    /**
     * Pad or truncate input string to fixed length
     * <code>
     * echo Phwoolcon\Text::padOrTruncate('123', '0', 4);       // prints 0123
     * echo Phwoolcon\Text::padOrTruncate('123456', '0', 4);    // prints 3456
     * </code>
     *
     * @param string $input
     * @param string $padding
     * @param int $length
     * @return string
     */
    public static function padOrTruncate($input, $padding, $length)
    {
        return isset($input{$length}) ? substr($input, -$length) : str_pad($input, $length, $padding, STR_PAD_LEFT);
    }

    public static function token()
    {
        return bin2hex(random_bytes(16));
    }
}
