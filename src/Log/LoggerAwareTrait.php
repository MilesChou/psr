<?php

namespace MilesChou\PsrSupport\Log;

use Psr\Log\LoggerAwareTrait as BaseLoggerAwareTrait;

trait LoggerAwareTrait
{
    use BaseLoggerAwareTrait;

    /**
     * Logging if logger exist
     *
     * @param int|string $level
     * @param string $message
     * @param array $context
     */
    protected function log($level, $message, array $context = [])
    {
        if (null !== $this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }
}
