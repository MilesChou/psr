<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

/**
 * Basic Implementation of HttpFactoryAwareInterface.
 */
trait HttpFactoryAwareTrait
{
    /**
     * @var HttpFactoryInterface
     */
    protected $httpFactory;

    /**
     * @param HttpFactoryInterface $httpFactory
     * @return static
     */
    public function setHttpFactory(HttpFactoryInterface $httpFactory)
    {
        $this->httpFactory = $httpFactory;
        return $this;
    }
}
