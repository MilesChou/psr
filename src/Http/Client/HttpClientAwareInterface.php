<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Client;

interface HttpClientAwareInterface
{
    /**
     * @param HttpClientInterface $client
     * @return static
     */
    public function setHttpClient(HttpClientInterface $client);
}
