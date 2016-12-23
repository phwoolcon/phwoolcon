<?php
namespace Phwoolcon;

use ErrorException;

trait PayloadTrait
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __call($method, $arguments)
    {
        if (($prefix = substr($method, 0, 3)) == 'get') {
            $property = Text::uncamelize(substr($method, 3));
            return $this->getData($property);
        } elseif ($prefix == 'set') {
            $property = Text::uncamelize(substr($method, 3));
            return $this->setData($property, fnGet($arguments, 0));
        }
        throw new ErrorException('Call to undefined method ' . get_class($this) . '::' . $method . '()');
    }

    public static function create(array $data)
    {
        return new static($data);
    }

    public function getData($key = null, $default = null)
    {
        return $key === null ? $this->data : fnGet($this->data, $key, $default);
    }

    public function hasData($key)
    {
        return isset($this->data[$key]);
    }

    public function setData($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = $key;
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }
}
