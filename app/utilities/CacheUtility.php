<?php

namespace App\Utilities;

use App\Utilities\Response;

/**
 * Cache utility class for handling response caching
 * 
 * This class provides methods for managing response caching, including
 * cache initialization, checking, and flushing. It uses file-based caching
 * with configurable expiration times and supports automatic cache invalidation
 * for non-GET requests.
 */
class CacheUtility
{
    /**
     * @var string Path to the cache file
     */
    protected static string $cache_file;

    /**
     * @var bool Whether caching is enabled
     */
    protected static bool $cache_enabled = CACHE_ENABLED;

    /**
     * @var int Cache expiration time in seconds
     */
    protected static int $cache_exp_time = CACHE_EXPIRE_TIME;

    /**
     * Initializes the cache system
     * 
     * Sets up the cache file path based on the request URI and disables
     * caching for non-GET requests. The cache file name is generated using
     * MD5 hash of the request URI.
     * 
     * @return void
     */
    public static function init(): void
    {
        self::$cache_file = CACHE_DIR . md5($_SERVER['REQUEST_URI']) . ".json";
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            self::$cache_enabled = 0;
    }

    /**
     * Checks if a valid cache exists
     * 
     * Validates if a cache file exists and hasn't expired based on the
     * configured expiration time.
     * 
     * @return bool True if a valid cache exists, false otherwise
     */
    public static function cache_exists(): bool
    {
        return (file_exists(self::$cache_file) && ((time() - filemtime(self::$cache_file)) < self::$cache_exp_time));
    }

    /**
     * Starts the caching process
     * 
     * If caching is enabled and a valid cache exists, serves the cached response
     * and terminates execution. Otherwise, starts output buffering for new
     * cache creation.
     * 
     * @return void
     */
    public static function start(): void
    {
        self::init();
        if (!self::$cache_enabled)
            return;
        if (self::cache_exists()) {
            Response::setHeaders();
            readfile(self::$cache_file);
            exit;
        }
        ob_start();
    }

    /**
     * Ends the caching process
     * 
     * If caching is enabled, write the buffered output to the cache file
     * and flushes the output buffer.
     * 
     * @return void
     */
    public static function end(): void
    {
        if (!self::$cache_enabled)
            return;
        file_put_contents(self::$cache_file, ob_get_contents());
        ob_end_flush();
    }

    /**
     * Flushes all cache files
     * 
     * Removes all cache files from the cache directory. This method is
     * typically called when the cache needs to be completely cleared.
     * 
     * @return void
     */
    public static function flush(): void
    {
        $files = glob(CACHE_DIR . "*");
        foreach ($files as $file)
            if (is_file($file))
                unlink($file);
    }
}
