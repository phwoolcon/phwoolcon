<?php

namespace Phwoolcon\Tests\Helper;

use Phwoolcon\View\Widget;

class TestWidget extends Widget
{

    public function hello($p1)
    {
        return "Hello {$p1}";
    }

    public static function helloStatic($p1, array $p2 = [])
    {
        return "Hello {$p1}, " . var_export($p2);
    }
}
