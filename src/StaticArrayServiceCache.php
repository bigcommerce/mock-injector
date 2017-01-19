<?php
declare(strict_types = 1);
namespace Bigcommerce\MockInjector;

use Bigcommerce\Injector\Cache\ArrayServiceCache;
use Bigcommerce\Injector\Cache\ServiceCacheInterface;

/**
 * Test only "singleton" for MockInjector reflection.
 * This allows reflection between separate instances of the MockInjector created for each unit test (which otherwise
 * causes unnecessary reflection of classes that have already been inspected).
 */
class StaticArrayServiceCache implements ServiceCacheInterface
{
    /** @var  ArrayServiceCache */
    public static $cache;
    public function __construct()
    {
        if(!isset(self::$cache)){
            self::$cache = new ArrayServiceCache();
        }
    }

    /**
     * Retrieve the value of a key in the cache.
     *
     * @param string $key
     * @return mixed|false cached value or false when key not present in a cache
     */
    public function get($key)
    {
        return self::$cache->get($key);
    }

    /**
     * Save a key/value pair to the cache.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        self::$cache->set($key, $value);
    }

    /**
     * Remove a key from the cache.
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        self::$cache->remove($key);
    }
}
