<?php
namespace Phwoolcon;

use Phalcon\Text as PhalconText;

class Text extends PhalconText
{

    public static function token()
    {
        return bin2hex(random_bytes(16));
    }
}
