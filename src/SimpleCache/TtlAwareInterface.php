<?php

namespace MilesChou\Psr\SimpleCache;

use DateInterval;

/**
 * Interface TtlAwareInterface is implemented by classes that depends on a Cache.
 */
interface TtlAwareInterface
{
    /**
     * Get the cache TTL
     *
     * @return null|int|DateInterval
     */
    public function getTtl();

    /**
     * Set the cache TTL
     *
     * @param null|int|DateInterval $ttl Unit is Second
     * @return static
     */
    public function setTtl($ttl);
}
