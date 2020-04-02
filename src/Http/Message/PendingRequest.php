<?php

namespace MilesChou\Psr\Http\Message;

use MilesChou\Psr\Http\Client\HttpClientAwareTrait;
use MilesChou\Psr\Http\Message\Traits\RequestProxy;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PendingRequest implements RequestInterface
{
    use HttpClientAwareTrait;
    use RequestProxy;

    /**
     * @param RequestInterface $request
     * @param ClientInterface|null $client
     */
    public function __construct(RequestInterface $request, ?ClientInterface $client = null)
    {
        $this->request = $request;
        $this->httpClient = $client;
    }

    public function send(): ResponseInterface
    {
        return $this->httpClient->sendRequest($this->request);
    }
}
