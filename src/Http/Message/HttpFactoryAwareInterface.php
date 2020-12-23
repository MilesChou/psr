<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

interface HttpFactoryAwareInterface
{
    /**
     * @param HttpFactoryInterface $httpFactory
     * @return static
     */
    public function setHttpFactory(HttpFactoryInterface $httpFactory);
}
