<?php

namespace MilesChou\Psr\Http\Client;

use Psr\Http\Client\ClientInterface;

interface ClientManagerInterface
{
    /**
     * Resolving driver
     *
     * @param string|null $name Return default driver when null
     * @return ClientInterface
     */
    public function driver(?string $name = null): ClientInterface;
}
