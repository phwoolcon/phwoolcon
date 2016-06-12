<?php
namespace Phwoolcon\Cli\Output;

use Phwoolcon\Protocol\StreamWrapperInterface;
use Phwoolcon\Protocol\StreamWrapperTrait;

class Stream implements StreamWrapperInterface
{
    use StreamWrapperTrait {
        stream_write as streamWriteReturn;
    }

    protected static $output = [];

    public function stream_flush()
    {
    }

    public function stream_open($path, $mode, $options, &$openedPath)
    {
        $this->path = $path;
        isset(static::$output[$path]) or static::$output[$path] = '';
        return true;
    }

    public function stream_read($count)
    {
        $start = $this->cursor;
        $eof = $this->eof;
        $this->updateCursor($count);
        return $eof ? false : substr(static::$output[$this->path], $start, $count);
    }

    public function stream_write($data)
    {
        // @codeCoverageIgnoreStart
        if (!isset(static::$output[$this->path])) {
            return 0;
        }
        // @codeCoverageIgnoreEnd
        static::$output[$this->path] .= $data;
        return $this->streamWriteReturn($data);
    }

    public function unlink($path)
    {
        unset(static::$output[$path]);
        return true;
    }
}
