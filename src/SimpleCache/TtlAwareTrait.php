<?php

namespace MilesChou\Psr\SimpleCache;

use DateInterval;

/**
 * Basic Implementation of TtlAwareInterface.
 */
trait TtlAwareTrait
{
    /**
     * @var null|int|DateInterval
     */
    protected $ttl = false;

    /**
     * Get the cache TTL
     *
     * Return default TTL when not set
     *
     * @return mixed
     */
    protected function getTtl()
    {
        if (false === $this->ttl) {
            $this->ttl = $this->getDefaultTtl();
        }

        return $this->ttl;
    }

    /**
     * Set the cache TTL
     *
     * @param null|int|DateInterval $ttl Unit is Second
     * @return static
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Setting default TTL
     *
     * @return null|int|DateInterval Unit is Second
     */
    abstract protected function getDefaultTtl();
}
