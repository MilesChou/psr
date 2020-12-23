<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Client;

use Psr\Http\Client\ClientInterface;

interface ClientAwareInterface
{
    /**
     * @param ClientInterface $client
     * @return static
     */
    public function setHttpClient(ClientInterface $client);
}
