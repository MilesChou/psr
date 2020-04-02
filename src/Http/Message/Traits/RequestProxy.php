<?php

namespace MilesChou\Psr\Http\Message\Traits;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

trait RequestProxy
{
    /**
     * @var RequestInterface
     */
    protected $request;

    public function getProtocolVersion()
    {
        return $this->request->getProtocolVersion();
    }

    public function withProtocolVersion($version)
    {
        $clone = clone $this;
        $clone->request = $this->request->withProtocolVersion($version);

        return $clone;
    }

    public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    public function hasHeader($name)
    {
        return $this->request->hasHeader($name);
    }

    public function getHeader($name)
    {
        return $this->request->getHeader($name);
    }

    public function getHeaderLine($name)
    {
        return $this->request->getHeaderLine($name);
    }

    public function withHeader($name, $value)
    {
        $clone = clone $this;
        $clone->request = $this->request->withHeader($name, $value);

        return $clone;
    }

    public function withAddedHeader($name, $value)
    {
        $clone = clone $this;
        $clone->request = $this->request->withAddedHeader($name, $value);

        return $clone;
    }

    public function withoutHeader($name)
    {
        $clone = clone $this;
        $clone->request = $this->request->withoutHeader($name);

        return $clone;
    }

    public function getBody()
    {
        return $this->request->getBody();
    }

    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->request = $this->request->withBody($body);

        return $clone;
    }

    public function getRequestTarget()
    {
        return $this->request->getRequestTarget();
    }

    public function withRequestTarget($requestTarget)
    {
        $clone = clone $this;
        $clone->request = $this->request->withRequestTarget($requestTarget);

        return $clone;
    }

    public function getMethod()
    {
        return $this->request->getMethod();
    }

    public function withMethod($method)
    {
        $clone = clone $this;
        $clone->request = $this->request->withMethod($method);

        return $clone;
    }

    public function getUri()
    {
        return $this->request->getUri();
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $clone = clone $this;
        $clone->request = $this->request->withUri($uri, $preserveHost);

        return $clone;
    }
}
