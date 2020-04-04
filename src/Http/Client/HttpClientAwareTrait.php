<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Client;

trait HttpClientAwareTrait
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(HttpClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}