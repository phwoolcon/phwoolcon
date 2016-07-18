<?php

namespace Phwoolcon\Assets;

use Exception;
use Phwoolcon\Log;

/**
 * Class ResourceTrait
 * @package Phwoolcon\Assets
 *
 * @property $_local
 * @property $_path
 */
trait ResourceTrait
{
    public static $basePath;
    public static $runningUnitTest = false;
    protected $content;

    public function concatenateHash($previousHash)
    {
        $hash = dechex(crc32($previousHash . $this->getContent(ResourceTrait::$basePath)));
        if (ResourceTrait::$runningUnitTest) {
            Log::debug(sprintf('Asset hash: [%s]', $hash));
        }
        return $hash;
    }

    public function getContent($basePath = null)
    {
        if ($this->content === null) {
            if (ResourceTrait::$runningUnitTest) {
                Log::debug(sprintf('Asset path: [%s]', $this->_path));
            }
            try {
                if ($this->_local) {
                    $this->content = parent::getContent($basePath);
                } else {
                    $path = $this->_path;
                    substr($this->_path, 0, 2) == '//' and $path = 'http:' . $path;
                    $this->content = file_get_contents($path, false, stream_context_create([
                        'http' => [
                            'method' => 'GET',
                            'timeout' => 1,
                        ],
                    ]));
                }
            } catch (Exception $e) {
                Log::exception($e);
                $this->content = '';
            }
        }
        return $this->content;
    }

    public static function setBasePath($path)
    {
        ResourceTrait::$basePath = $path;
    }

    public static function setRunningUnitTests($flag)
    {
        ResourceTrait::$runningUnitTest = $flag;
    }
}
