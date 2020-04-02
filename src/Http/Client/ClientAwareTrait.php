<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Client;

use Psr\Http\Client\ClientInterface;

trait ClientAwareTrait
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @param ClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}
