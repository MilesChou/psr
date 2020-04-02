<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

trait HttpFactoryAwareTrait
{
    /**
     * @var HttpFactoryInterface
     */
    protected $httpFactory;

    /**
     * @param HttpFactoryInterface $httpFactory
     * @return $this
     */
    public function setHttpFactory(HttpFactoryInterface $httpFactory): self
    {
        $this->httpFactory = $httpFactory;
        return $this;
    }
}
