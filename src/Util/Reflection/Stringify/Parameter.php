<?php
namespace Phwoolcon\Util\Reflection\Stringify;

use ReflectionParameter;

class Parameter
{

    public static function cast(ReflectionParameter $parameter)
    {
        $stringify = '';
        // @codeCoverageIgnoreStart
        if (PHP_VERSION_ID >= 70000 && $parameter->hasType()) {
            $stringify .= $parameter->getType()->__toString() . ' ';
        } else {
            if ($parameter->isArray()) {
                $stringify .= 'array ';
            } elseif ($type = $parameter->getClass()) {
                $stringify .= $type->getName() . ' ';
            } elseif ($parameter->isCallable()) {
                $stringify .= 'callable ';
            }
        }
        // @codeCoverageIgnoreEnd
        $parameter->isPassedByReference() and $stringify .= '&';
        $stringify .= '$' . $parameter->getName();
        if ($parameter->isOptional()) {
            $default = var_export($parameter->getDefaultValue(), true);
            if ($const = $parameter->getDefaultValueConstantName()) {
                $const = defined($const) ? $const : substr(strrchr($const, '\\'), 1);
                defined($const) and $default = $const;
            }
            $default == 'NULL' and $default = 'null';
            $stringify .= ' = ' . $default;
        }
        return $stringify;
    }
}
