<?php

namespace MilesChou\Psr\Http\Message\Traits;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

trait ResponseProxy
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    public function getProtocolVersion()
    {
        return $this->response->getProtocolVersion();
    }

    public function withProtocolVersion($version)
    {
        $clone = clone $this;
        $clone->response = $this->response->withProtocolVersion($version);

        return $clone;
    }

    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    public function hasHeader($name)
    {
        return $this->response->hasHeader($name);
    }

    public function getHeader($name)
    {
        return $this->response->getHeader($name);
    }

    public function getHeaderLine($name)
    {
        return $this->response->getHeaderLine($name);
    }

    public function withHeader($name, $value)
    {
        $clone = clone $this;
        $clone->response = $this->response->withHeader($name, $value);

        return $clone;
    }

    public function withAddedHeader($name, $value)
    {
        $clone = clone $this;
        $clone->response = $this->response->withAddedHeader($name, $value);

        return $clone;
    }

    public function withoutHeader($name)
    {
        $clone = clone $this;
        $clone->response = $this->response->withoutHeader($name);

        return $clone;
    }

    public function getBody()
    {
        return $this->response->getBody();
    }

    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->response = $this->response->withBody($body);

        return $clone;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        $clone = clone $this;
        $clone->response = $this->response->withStatus($code, $reasonPhrase);

        return $clone;
    }

    public function getReasonPhrase()
    {
        return $this->response->getReasonPhrase();
    }
}
