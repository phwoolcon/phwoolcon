<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Db;
use Phwoolcon\Tests\TestCase;
use Phwoolcon\Tests\TestModel;

class ModelTest extends TestCase
{

    protected function getModelInstance()
    {
        return new TestModel;
    }

    public function setUp()
    {
        parent::setUp();
        Db::clearMetadata();
    }

    public function testSetDataAndGetData()
    {
        $model = $this->getModelInstance();
        $key = 'test';
        $value = 'test value';
        $model->setData($key, $value);
        $this->assertEquals($value, $model->getData($key));
    }

    public function testSave()
    {
        $model = $this->getModelInstance();
        $model->setValue('Test value');
        $this->assertTrue($model->save(), 'Unable to save model');
        $this->assertNotEmpty($model->getKey(), 'Unable to generate id');
    }
}
