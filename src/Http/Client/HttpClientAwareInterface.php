<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Client;

use Psr\Http\Client\ClientInterface;

interface HttpClientAwareInterface
{
    /**
     * @param ClientInterface $client
     */
    public function setHttpClient(ClientInterface $client);
}
