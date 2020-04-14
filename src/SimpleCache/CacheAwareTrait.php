<?php

namespace MilesChou\Psr\SimpleCache;

use Psr\SimpleCache\CacheInterface;

/**
 * Basic Implementation of CacheAwareInterface.
 */
trait CacheAwareTrait
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Set the cache driver
     *
     * @param CacheInterface|null $cache
     * @return $this
     */
    public function setCache(?CacheInterface $cache = null)
    {
        $this->cache = $cache;

        return $this;
    }
}
