<?php
namespace Phwoolcon\Model;

use Phwoolcon\Cache;
use Phwoolcon\Config as PhwoolconConfig;
use Phwoolcon\Db;
use Phwoolcon\Model;
use Phalcon\Db\Column;

class Config extends Model
{
    protected $_table = 'config';
    protected $_useDistributedId = false;

    public static function all()
    {
        $environment = PhwoolconConfig::environment();
        if (null === $config = Cache::get($key = 'db_configs_' . $environment)) {
            $db = Db::connection();
            $db->tableExists('config') or static::createConfigTable();

            $config = [];
            /* @var static $row */
            foreach (static::find() as $row) {
                $value = json_decode($row->getData('value'), true);
                $config[$row->getData('key')] = $value;
            }
            Cache::set($key, $config, Cache::TTL_ONE_MONTH);
        }
        return $config;
    }

    protected static function createConfigTable()
    {
        $db = Db::connection();
        $db->createTable('config', null, [
            'columns' => [
                new Column('key', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 32,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('value', [
                    'type' => Column::TYPE_TEXT,
                ]),
            ],
        ]);
        if (PhwoolconConfig::runningUnitTest()) {
            static::saveConfig('_testing', ['k' => 'v']);
        }
    }

    public static function saveConfig($key, $value)
    {
        $value = json_encode($value);
        /* @var Config $config */
        $config = new static;
        $config->setData('key', $key)
            ->setData('value', $value)
            ->save();
    }
}
