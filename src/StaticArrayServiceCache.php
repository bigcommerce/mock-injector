<?php
declare(strict_types = 1);
namespace Bigcommerce\MockInjector;

use Bigcommerce\Injector\Cache\ArrayServiceCache;
use Bigcommerce\Injector\Cache\ServiceCacheInterface;

/**
 * Test only "singleton" for MockInjector reflection.
 * This allows reflection between separate instances of the MockInjector created for each unit test (which otherwise
 * causes unnecessary reflection of classes that have already been inspected).
 *
 * @template T
 */
class StaticArrayServiceCache implements ServiceCacheInterface
{
    /** @var ArrayServiceCache<T>|null */
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
     * @return T|false cached value or false when key not present in a cache
     */
    public function get(string $key): mixed
    {
        return self::$cache->get($key);
    }

    /**
     * Save a key/value pair to the cache.
     *
     * @param string $key
     * @param T $value
     * @return void
     */
    public function set(string $key, mixed $value)
    {
        self::$cache->set($key, $value);
    }

    /**
     * Remove a key from the cache.
     *
     * @param string $key
     * @return void
     */
    public function remove($key): void
    {
        self::$cache->remove($key);
    }

    /**
     * Check if a key exists in the cache.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return self::$cache->has($key);
    }
}
