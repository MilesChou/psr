<?php

namespace MilesChou\Psr\Http\Client;

use OutOfRangeException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientManager implements ClientInterface, ClientManagerInterface
{
    use ClientAwareTrait;

    /**
     * @var array<ClientInterface>
     */
    private $drivers = [];

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->setDefault($httpClient);
    }

    /**
     * Register a HTTP client
     *
     * @param string $name
     * @param ClientInterface $client
     */
    public function add(string $name, ClientInterface $client): void
    {
        $this->drivers[$name] = $client;
    }

    /**
     * @param string $name
     * @return ClientInterface
     */
    public function driver(?string $name = null): ClientInterface
    {
        if (null === $name) {
            return $this->httpClient;
        }

        if ($this->has($name)) {
            return $this->drivers[$name];
        }

        throw new OutOfRangeException("Client driver '{$name}' is not found");
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->drivers[$name]);
    }

    /**
     * Proxy to httpClient driver
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Alias to setHttpClient()
     *
     * @param ClientInterface $httpClient
     * @return $this
     */
    public function setDefault(ClientInterface $httpClient): self
    {
        $this->setHttpClient($httpClient);

        return $this;
    }
}
