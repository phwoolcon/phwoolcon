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
        return file_get_contents($this->_path, false, stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 10,
            ],
        ]));
    }
}
