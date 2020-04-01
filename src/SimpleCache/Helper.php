<?php

declare(strict_types=1);

namespace MilesChou\Psr\SimpleCache;

use DateInterval;
use DateTimeImmutable;
use MilesChou\Psr\SimpleCache\Exceptions\InvalidArgumentException;
use Traversable;

/**
 * Helper
 */
class Helper
{
    /**
     * @param mixed $value
     */
    public static function checkStringType($value): void
    {
        if (!is_string($value)) {
            $type = gettype($value);
            throw new InvalidArgumentException("Input must be a string. Given is: $type");
        }
    }

    /**
     * @param mixed $value
     */
    public static function checkTraversableType($value): void
    {
        if (!is_array($value) && !($value instanceof Traversable)) {
            $type = gettype($value);
            throw new InvalidArgumentException("Input must be an array or Traversable. Given is: $type");
        }
    }

    /**
     * @param mixed $value
     */
    public static function checkTtlType($value): void
    {
        $isNull = $value === null;
        $isInt = is_int($value);
        $isDateInterval = $value instanceof DateInterval;

        if (!$isNull && !$isInt && !$isDateInterval) {
            $type = gettype($value);
            throw new InvalidArgumentException("Ttl must be null, an integer or a DateInterval. Given is: $type");
        }
    }

    /**
     * Normalize timestamp for expire at
     *
     * @param null|int|DateInterval $ttl
     * @return null|int
     */
    public static function normalizeExpireAt($ttl): ?int
    {
        self::checkTtlType($ttl);

        if (is_int($ttl)) {
            return time() + $ttl;
        }

        if ($ttl instanceof DateInterval) {
            $now = new DateTimeImmutable();
            return $now->add($ttl)->getTimestamp();
        }

        return null;
    }

    /**
     * Normalize timestamp for TTL
     *
     * @param null|int|DateInterval $ttl
     * @return null|int
     */
    public static function normalizeTtl($ttl): ?int
    {
        self::checkTtlType($ttl);

        if (is_int($ttl)) {
            return $ttl;
        }

        if ($ttl instanceof DateInterval) {
            $now = new DateTimeImmutable();
            return $now->add($ttl)->getTimestamp() - $now->getTimestamp();
        }

        return null;
    }
}
