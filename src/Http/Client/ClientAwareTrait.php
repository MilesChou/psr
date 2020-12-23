<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Client;

use Psr\Http\Client\ClientInterface;

/**
 * Basic Implementation of ClientAwareInterface.
 */
trait ClientAwareTrait
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @param ClientInterface $httpClient
     * @return static
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}
