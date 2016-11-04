<?php
namespace Phwoolcon\Util\Counter;

interface AdapterInterface
{

    public function increment($keyName, $value = 1);

    public function decrement($keyName, $value = 1);

    public function reset($keyName);
}
