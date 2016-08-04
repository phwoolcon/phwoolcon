<?php
namespace Phwoolcon\Util;

class Timer
{
    protected static $_times;

    public static function start()
    {
        return static::$_times[0] = explode(' ', microtime());
    }

    public static function stop()
    {
        static::$_times[1] = explode(' ', microtime());
        return (static::$_times[1][0] - static::$_times[0][0]) + (static::$_times[1][1] - static::$_times[0][1]);
    }
}
