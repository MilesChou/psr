<?php

declare(strict_types=1);

namespace MilesChou\Psr\SimpleCache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

/**
 * Trait CacheAwareTrait is used by classes that implements CacheAwareInterface.
 */
trait CacheAwareTrait
{
    /**
     * @var null|int|DateInterval
     */
    private $ttl = false;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Set the cache driver
     */
    public function getTtl()
    {
        if (false === $this->ttl) {
            $this->ttl = $this->getDefaultTtl();
        }

        return $this->ttl;
    }

    /**
     * Set the cache driver
     *
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache = null): void
    {
        $this->cache = $cache;
    }

    /**
     * Set the cache TTL
     *
     * @param null|int|DateInterval $ttl Unit is Second
     */
    public function setTtl($ttl): void
    {
        Helper::checkTtlType($ttl);

        $this->ttl = $ttl;
    }

    /**
     * Use Trait must implement this function for setting default TTL
     *
     * @return null|int|DateInterval Unit is Second
     */
    abstract public function getDefaultTtl();
}
