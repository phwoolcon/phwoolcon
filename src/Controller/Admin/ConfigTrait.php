<?php
namespace Phwoolcon\Controller\Admin;

use Phalcon\Validation\Exception as ValidationException;
use Phwoolcon\Config;
use Phwoolcon\Model\Config as ConfigModel;

trait ConfigTrait
{

    protected function filterConfig($key, $data)
    {
        unset($data['_sensitive_keys'], $data['_allowed_keys']);
        // Process white list
        if (is_array($allowedKeys = Config::get($key . '._allowed_keys'))) {
            $allowedData = [];
            foreach ($allowedKeys as $key) {
                array_set($allowedData, $key, fnGet($data, $key));
            }
            return $allowedData;
        }
        // Process black list
        if (is_array($sensitiveKeys = Config::get($key . '._sensitive_keys'))) {
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

    protected function keyList()
    {
        $keys = [];
        foreach (Config::get() as $key => $value) {
            if (is_array(fnGet($value, '_sensitive_keys')) || is_array(fnGet($value, '_allowed_keys'))) {
                $keys[$key] = $key;
            }
        }
        ksort($keys);
        return $keys;
    }

    protected function submitConfig($key, $data)
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new ValidationException(json_last_error_msg(), json_last_error());
            }
        }
        $value = $this->filterConfig($key, $data);
        ConfigModel::saveConfig($key, $value);
        Config::clearCache();
        return $value;
    }
}
