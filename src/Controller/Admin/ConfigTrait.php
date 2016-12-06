<?php
namespace Phwoolcon\Controller\Admin;

use Phalcon\Validation\Exception as ValidationException;
use Phwoolcon\Config;
use Phwoolcon\Model\Config as ConfigModel;

trait ConfigTrait
{

    protected function filterConfig($key, $data)
    {
        unset($data['_black_list'], $data['_white_list']);
        // Process white list
        if (is_array($allowedKeys = Config::get($key . '._white_list'))) {
            $allowedData = [];
            foreach ($allowedKeys as $key) {
                array_set($allowedData, $key, fnGet($data, $key));
            }
            return $allowedData;
        }
        // Process black list
        if (is_array($sensitiveKeys = Config::get($key . '._black_list'))) {
            foreach ($sensitiveKeys as $key) {
                array_forget($data, $key);
            }
            return $data;
        }
        throw new ValidationException("Config group '{$key}' is protected");
    }

    protected function getCurrentConfig($key)
    {
        $data = Config::get($key);
        return $this->filterConfig($key, $data);
    }

    public static function getKeyLabel($key)
    {
        $labelKey = 'config_key_' . $key;
        $label = __($labelKey);
        return $label == $labelKey ? $key : $label;
    }

    protected function keyList()
    {
        $keys = [];
        foreach (Config::get() as $key => $value) {
            if (is_array(fnGet($value, '_black_list')) || is_array(fnGet($value, '_white_list'))) {
                $keys[$key] = static::getKeyLabel($key);
            }
        }
        ksort($keys);
        return $keys;
    }

    protected function submitConfig($key, $data)
    {
        if ($data === '' || $data === null) {
            $value = null;
        } else {
            if (is_string($data)) {
                $data = json_decode($data, true);
                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new ValidationException(json_last_error_msg(), json_last_error());
                }
            }
            $value = $this->filterConfig($key, $data);
        }
        ConfigModel::saveConfig($key, $value);
        return $value;
    }
}
