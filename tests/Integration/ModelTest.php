<?php
namespace Phwoolcon\Tests\Integration;

use Phwoolcon\Db;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Tests\Helper\TestModel;

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
        $storedData['created_at'] = $model->created_at;
        $storedData['updated_at'] = $model->updated_at;
        $this->assertEquals($storedData, $model->getData());
    }

    public function testSave()
    {
        $model = $this->getModelInstance();
        $model->setValue($value = ['test__call' => 'Test __call() setValue']);
        $this->assertEmpty($model->getStringMessages());
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
        $value['created_at'] = $model->created_at;
        $value['updated_at'] = $model->updated_at;
        $this->assertEquals($value, $found->getData(), 'Bad db loaded value');
    }

    public function testLoadList()
    {
        $model = $this->getModelInstance();
        $model->setData($value = [
            'key' => $key = 'test-key2',
            'value' => ['foo' => 'bar'],
        ]);
        $model->save();

        // Test findSimple
        $list = $model::findSimple(['key' => ['LIKE', 'test%']], [], 'key ASC', '*', 10);
        $this->assertGreaterThan(0, $list->count(), 'Unable to load model list from db');

        // Test findSimple, limit with offset
        $list = $model::findSimple(['key' => ['LIKE', 'test%']], [], 'key ASC', '*', '10, 0');
        $this->assertGreaterThan(0, $list->count(), 'Unable to load model list from db');

        // Test countSimple
        $this->assertGreaterThan(
            0,
            $model::countSimple('key LIKE :test_bind:', ['test_bind' => 'test%']),
            'Unable to get model count from db'
        );
        $this->assertGreaterThan(0, $model::countSimple('key LIKE "test%"'), 'Unable to get model count from db');
    }

    public function testExecuteSql()
    {
        $model = $this->getModelInstance();
        $model->setData([
            'key' => $key = 'test-key3',
            'value' => ['foo' => 'bar'],
        ]);
        $model->save();
        $table = $model->getSource();

        // Test sqlFetchAll
        $this->assertNotEmpty($model->sqlFetchAll("SELECT * FROM {$table} WHERE `key` LIKE :test_bind:", [
            'test_bind' => 'test%',
        ]));
        $this->assertNotEmpty($model->sqlFetchAll("SELECT * FROM {$table} WHERE `key` IN ({test_bind:array})", [
            'test_bind' => [$key],
        ]));

        // Test sqlFetchColumn
        $this->assertEquals(2, (int)$model->sqlFetchColumn("SELECT 1 + 1"));

        // Test sqlExecute INSERT
        $key = 'test-key4';
        $value = 'foo';
        $selectSql = "SELECT `value` FROM {$table} WHERE `key` IN ({test_bind:array})";
        $this->assertTrue($model->sqlExecute("INSERT INTO {$table} (`key`, `value`) VALUES ('{$key}', '{$value}')"));
        $this->assertEquals($value, $model->sqlFetchColumn($selectSql, [
            'test_bind' => [$key],
        ]));

        // Test sqlExecute UPDATE
        $value = 'bar';
        $updateSql = "UPDATE {$table} SET `value` = '{$value}' WHERE `key` IN ({test_bind:array})";
        $this->assertTrue($model->sqlExecute($updateSql, [
            'test_bind' => [$key],
        ]));
        $this->assertEquals($value, $model->sqlFetchColumn($selectSql, [
            'test_bind' => [$key],
        ]));

        // Test sqlExecute DELETE
        $this->assertTrue($model->sqlExecute("DELETE FROM {$table} WHERE `key` IN ({test_bind:array})", [
            'test_bind' => [$key],
        ]));
        $this->assertFalse($model->sqlFetchColumn($selectSql, [
            'test_bind' => [$key],
        ]));
    }

    public function testReset()
    {
        $model = $this->getModelInstance();
        $value = $model->getData();
        $model->setData([
            'key' => $key = 'test-key',
            'value' => ['foo' => 'bar'],
        ]);
        $this->assertNotEquals($value, $model->getData(), 'Unable to set data');
        $model->save();
        $this->assertFalse($model->isNew(), 'Unable to set isNew after save');
        $model->reset();
        $this->assertEquals($value, $model->getData(), 'Unable to reset');
        $this->assertTrue($model->isNew(), 'Unable to reset isNew status');
    }

    public function testErrorMessage()
    {
        $model = $this->getModelInstance();
        $model->setId('1');
        $model->save();
        $this->assertNotEmpty($model->getStringMessages(), 'Model pre save validation not triggered');
    }
}
