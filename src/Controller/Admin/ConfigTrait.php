<?php
namespace Phwoolcon\Controller\Admin;

use Phalcon\Validation\Exception as ValidationException;
use Phwoolcon\Config;
use Phwoolcon\Model\Config as ConfigModel;

trait ConfigTrait
{

    protected function filterSubmittedConfig($key, $data)
    {
        unset($data['_sensitive_keys']);
        if (is_array($sensitiveKeys = Config::get($key . '._sensitive_keys'))) {
            foreach ($sensitiveKeys as $key) {
                if ($key == '*') {
                    throw new ValidationException("Config group '{$key}' is protected");
                }
                array_forget($data, $key);
            }
        }
        return $data;
    }

    protected function submitConfig($key, $data)
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new ValidationException(json_last_error_msg(), json_last_error());
            }
        }
        $value = $this->filterSubmittedConfig($key, $data);
        ConfigModel::saveConfig($key, $value);
        Config::clearCache();
    }
}
