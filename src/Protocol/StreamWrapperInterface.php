<?php
namespace Phwoolcon\Protocol;

interface StreamWrapperInterface
{

    public function __construct();

    /**
     * Close directory handle
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function dir_closedir();

    /**
     * Open directory handle
     *
     * @param string $path    Specifies the URL that was passed to opendir().
     * @param int    $options Whether or not to enforce safe_mode (0x04).
     *
     * @return bool
     */
    public function dir_opendir($path, $options);

    /**
     * Read entry from directory handle
     *
     * @return string|false Should return string representing the next filename, or FALSE if there is no next file.
     */
    public function dir_readdir();

    /**
     * Rewind directory handle
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function dir_rewinddir();

    /**
     * Create a directory
     *
     * @param string $path    Directory which should be created.
     * @param int    $mode    The value passed to mkdir().
     * @param int    $options A bitwise mask of values, such as STREAM_MKDIR_RECURSIVE.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function mkdir($path, $mode, $options);

    /**
     * Renames a file or directory
     *
     * @param string $pathFrom The URL to the current file.
     * @param string $pathTo   he URL which the $pathFrom should be renamed to.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function rename($pathFrom, $pathTo);

    /**
     * Removes a directory
     *
     * @param string $path    The directory URL which should be removed.
     * @param int    $options A bitwise mask of values, such as STREAM_MKDIR_RECURSIVE.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function rmdir($path, $options);

    /**
     * Retrieve the underlaying resource
     *
     * @param int $castAs STREAM_CAST_FOR_SELECT or STREAM_CAST_AS_STREAM
     *
     * @return resource|false Should return the underlying stream resource used by the wrapper, or FALSE.
     */
    public function stream_cast($castAs);

    /**
     * Close a resource
     */
    public function stream_close();

    /**
     * Tests for end-of-file on a file pointer
     *
     * @return bool Should return TRUE if the read/write position is at the end of the stream and if no more data is
     *              available to be read, or FALSE otherwise.
     */
    public function stream_eof();

    /**
     * Flushes the output
     *
     * @return bool Should return TRUE if the cached data was successfully stored (or if there was no data to store),
     *              or FALSE if the data could not be stored.
     */
    public function stream_flush();

    /**
     * Advisory file locking
     *
     * @param int $operation LOCK_SH to acquire a shared lock (reader).
     *                       LOCK_EX to acquire an exclusive lock (writer).
     *                       LOCK_UN to release a lock (shared or exclusive).
     *                       LOCK_NB if you don't want flock() to block while locking. (not supported on Windows)
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function stream_lock($operation);

    /**
     * Change stream options
     *
     * @param string $path   The file path or URL to set metadata.
     * @param int    $option One of: STREAM_META_TOUCH, STREAM_META_OWNER_NAME, STREAM_META_OWNER,
     *                       STREAM_META_GROUP_NAME, STREAM_META_GROUP, STREAM_META_ACCESS
     * @param mixed  $value  If option is:
     *                       STREAM_META_TOUCH: Array consisting of two arguments of the touch() function.
     *                       STREAM_META_OWNER_NAME, STREAM_META_GROUP_NAME: The name of the owner user/group as string.
     *                       STREAM_META_OWNER, STREAM_META_GROUP: The value owner user/group argument as integer.
     *                       STREAM_META_ACCESS: The argument of the chmod() as integer.
     *
     * @return bool Returns TRUE on success or FALSE on failure. If option is not implemented, FALSE should be
     *              returned.
     */
    public function stream_metadata($path, $option, $value);

    /**
     * Opens file or URL
     *
     * @param string $path        Specifies the URL that was passed to the original function.
     * @param string $mode        The mode used to open the file, as detailed for fopen().
     * @param int    $options     STREAM_USE_PATH or STREAM_REPORT_ERRORS
     * @param string &$openedPath If the path is opened successfully, and STREAM_USE_PATH is set in options,
     *                            opened_path should be set to the full path of the file/resource that was actually
     *                            opened.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function stream_open($path, $mode, $options, &$openedPath);

    /**
     * Read from stream
     *
     * @param int $count    How many bytes of data from the current position should be returned.
     * @return string|false If there are less than count bytes available, return as many as are available.
     *                      If no more data is available, return either FALSE or an empty string.
     */
    public function stream_read($count);

    /**
     * Seeks to specific location in a stream
     *
     * @param int $offset The stream offset to seek to.
     * @param int $whence SEEK_SET, SEEK_CUR or SEEK_END
     *
     * @return bool Return TRUE if the position was updated, FALSE otherwise.
     */
    public function stream_seek($offset, $whence = SEEK_SET);

    /**
     * Change stream options
     *
     * @param int $option STREAM_OPTION_BLOCKING, STREAM_OPTION_READ_TIMEOUT or STREAM_OPTION_WRITE_BUFFER
     * @param int $arg1   If option is:
     *                    STREAM_OPTION_BLOCKING: requested blocking mode (1 meaning block 0 not blocking).
     *                    STREAM_OPTION_READ_TIMEOUT: the timeout in seconds.
     *                    STREAM_OPTION_WRITE_BUFFER: buffer mode (STREAM_BUFFER_NONE or STREAM_BUFFER_FULL).
     * @param int $arg2   If option is:
     *                    STREAM_OPTION_BLOCKING: This option is not set.
     *                    STREAM_OPTION_READ_TIMEOUT: the timeout in microseconds.
     *                    STREAM_OPTION_WRITE_BUFFER: the requested buffer size.
     *
     * @return bool Returns TRUE on success or FALSE on failure. If option is not implemented, FALSE should be returned.
     */
    public function stream_set_option($option, $arg1, $arg2);

    /**
     * Retrieve information about a file resource
     *
     * @return array See stat().
     *
     * @see stat()
     */
    public function stream_stat();

    /**
     * Retrieve the current position of a stream
     *
     * @return int Should return the current position of the stream.
     */
    public function stream_tell();

    /**
     * Truncate stream
     *
     * @param int $newSize The new size.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function stream_truncate($newSize);

    /**
     * Write to stream
     *
     * @param string $data The data should be stored into the underlying stream.
     *
     * @return int Should return the number of bytes that were successfully stored, or 0 if none could be stored.
     */
    public function stream_write($data);

    /**
     * Delete a file
     *
     * @param string $path The file URL which should be deleted.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function unlink($path);

    /**
     * Retrieve information about a file
     *
     * @param string $path  The file path or URL to stat.
     * @param int    $flags STREAM_URL_STAT_LINK or STREAM_URL_STAT_QUIET
     *
     * @return array Should return as many elements as stat() does.
     *               Unknown or unavailable values should be set to a rational value (usually 0).
     */
    public function url_stat($path, $flags);
}
