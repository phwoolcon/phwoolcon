<?php
namespace Phwoolcon\Model\DynamicTrait;

use Phalcon\Di;
use Phwoolcon\Text;

class Loader
{
    protected static $instance;
    protected $suffix = 'ModelTrait';

    protected function __construct()
    {
        spl_autoload_register([$this, 'autoLoad']);
    }

    public static function register(Di $di)
    {
        static::$instance === null and static::$instance = new static();
    }

    public function autoLoad($className)
    {
        if (Text::endsWith($className, $this->suffix, false) && trait_exists(EmptyTrait::class)) {
            class_alias(EmptyTrait::class, $className);
            return true;
        }
        // @codeCoverageIgnoreStart
        return false;
        // @codeCoverageIgnoreEnd
    }
}
