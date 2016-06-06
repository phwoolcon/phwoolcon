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
        $this->assertEquals($value, $model->getAdditionalData($key));
    }

    public function testAddData()
    {
        $model = $this->getModelInstance();
        $model->addData($data = [
            'key' => 'k',
            'value' => 'v',
            'non-existing' => 'n',
        ]);
        $storedData = $data;
        unset($storedData['non-existing']);
        $this->assertEquals($storedData, $model->getData());
    }

    public function testSave()
    {
        $model = $this->getModelInstance();
        $model->setValue($value = ['test__call' => 'Test __call() setValue']);
        $this->assertEquals($value, $model->getValue());
        $this->assertTrue($model->save(), 'Unable to save model');
        $this->assertNotEmpty($model->getKey(), 'Unable to generate id');
    }

    public function testLoad()
    {
        $model = $this->getModelInstance();
        $model->setData($value = [
            'key' => $key = 'test-key',
            'value' => ['foo' => 'bar'],
        ]);
        $model->save();
        $found = $model::findFirstSimple(compact('key'));
        $this->assertInstanceOf(get_class($model), $found, 'Unable to load model from db');
        $this->assertEquals($value, $found->getData(), 'Bad db loaded value');
    }
}
