<?php
namespace Phwoolcon\Tests\Helper\Admin;

use Phwoolcon\Controller\Admin\ConfigTrait;

class TestConfigTrait
{
    use ConfigTrait {
        filterConfig as public;
        getCurrentConfig as public;
        keyList as public;
        submitConfig as public;
    }
}
