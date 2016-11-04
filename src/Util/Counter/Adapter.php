<?php
namespace Phwoolcon\Util\Counter;

abstract class Adapter implements AdapterInterface
{
    protected $options = [];

    public function __construct($options)
    {
        $this->options = $options;
    }
}
