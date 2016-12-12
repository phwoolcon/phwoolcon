<?php
namespace Phwoolcon\Tests\Unit\Model;

use Phwoolcon\Model\DynamicTrait\EmptyTrait;
use Phwoolcon\Model\DynamicTrait\Loader;
use Phwoolcon\Tests\Helper\Model\TestDynamicTrait;
use Phwoolcon\Tests\Helper\TestCase;

class DynamicTraitTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Loader::register($this->di);
    }

    public function testLoadTrait()
    {
        $model = new TestDynamicTrait();
        $traits = class_uses($model);
        $this->assertArrayHasKey(EmptyTrait::class, $traits);
    }
}
