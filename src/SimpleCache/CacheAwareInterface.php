<?php

namespace MilesChou\Psr\SimpleCache;

use Psr\SimpleCache\CacheInterface;

/**
 * Interface CacheAwareInterface is implemented by classes that depends on a Cache.
 */
interface CacheAwareInterface
{
    /**
     * Set the cache driver
     *
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache);
}
