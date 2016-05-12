<?php

namespace Phwoolcon\Assets;

/**
 * Class ResourceTrait
 * @package Phwoolcon\Assets
 *
 * @property $_local
 * @property $_path
 */
trait ResourceTrait
{

    public function getContent($basePath = null)
    {
        if ($this->_local) {
            return parent::getContent($basePath);
        }
        $path = $this->_path;
        substr($this->_path, 0, 2) == '//' and $path = 'http:' . $path;
        return file_get_contents($path, false, stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 1,
            ],
        ]));
    }
}
