<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\StreamFactoryInterface;

class StreamFactory implements StreamFactoryInterface
{
    use Traits\StreamFactoryDetector;

    /**
     * @param StreamFactoryInterface|null $factory
     */
    public function __construct($factory = null)
    {
        $this->setStreamFactory($factory);
    }
}
