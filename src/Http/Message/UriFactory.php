<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\UriFactoryInterface;

class UriFactory implements UriFactoryInterface
{
    use Traits\UriFactoryDetector;

    /**
     * @param UriFactoryInterface|null $factory
     */
    public function __construct($factory = null)
    {
        $this->setUriFactory($factory);
    }
}
