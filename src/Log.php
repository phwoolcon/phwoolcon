<?php
namespace Phwoolcon;

use Phalcon\Di;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File;
use Phalcon\Logger\Formatter\Line;
use Phwoolcon\Exception\HttpException;

class Log extends Logger
{
    /**
     * @var \Phalcon\Logger\Adapter|File
     */
    protected static $logger;
    protected static $hostname;

    public static function debug($message = null, array $context = [])
    {
        static::log(static::DEBUG, $message, $context);
    }

    public static function error($message = null, array $context = [])
    {
        static::log(static::ERROR, $message, $context);
    }

    /**
     * @param \Throwable $e
     */
    public static function exception($e)
    {
        $message = get_class($e);
        $e instanceof HttpException or $message .= "\n" . $e->__toString();
        static::error($message);
    }

    public static function info($message = null, array $context = [])
    {
        static::log(static::INFO, $message, $context);
    }

    public static function log($type, $message = null, array $context = [])
    {
        static::$logger or static::$logger = Di::getDefault()->getShared('log');
        $context['host'] = static::$hostname;
        $context['request'] = fnGet($_SERVER, 'REQUEST_METHOD') . ' ' . fnGet($_SERVER, 'REQUEST_URI');
        static::$logger->log($type, $message, $context);
    }

    public static function register(Di $di)
    {
        static::$hostname = gethostname();
        $di->remove('log');
        static::$logger = null;
        $di->setShared('log', function () {
            $filePath = storagePath('logs');
            is_dir($filePath) or mkdir($filePath, 0777, true);
            $filePath .= '/' . Config::get('app.log.file', 'phwoolcon.log');
            $logger = new File($filePath);
            $logger->setLogLevel(Config::get('app.log.level', Logger::NOTICE));
            $formatter = $logger->getFormatter();
            if ($formatter instanceof Line) {
                $formatter->setDateFormat('Y-m-d H:i:s');
                $formatter->setFormat('[%date%]{host}[%type%] {request} %message%');
            }
            return $logger;
        });
    }

    /**
     * @codeCoverageIgnore
     * @param string $message
     * @param array  $context
     */
    public static function warning($message = null, array $context = [])
    {
        static::log(static::WARNING, $message, $context);
    }
}
