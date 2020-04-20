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

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->request->getProtocolVersion();
    }

    /**
     * @inheritDoc
     *
     * @param string $version
     * @return static
     */
    public function withProtocolVersion($version)
    {
        $clone = clone $this;
        $clone->request = $this->request->withProtocolVersion($version);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @return bool
     */
    public function hasHeader($name)
    {
        return $this->request->hasHeader($name);
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @return array
     */
    public function getHeader($name)
    {
        return $this->request->getHeader($name);
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @return string
     */
    public function getHeaderLine($name)
    {
        return $this->request->getHeaderLine($name);
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @param string|string[] $value
     * @return static
     */
    public function withHeader($name, $value)
    {
        $clone = clone $this;
        $clone->request = $this->request->withHeader($name, $value);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @param string|string[] $value
     * @return static
     */
    public function withAddedHeader($name, $value)
    {
        $clone = clone $this;
        $clone->request = $this->request->withAddedHeader($name, $value);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @return static
     */
    public function withoutHeader($name)
    {
        $clone = clone $this;
        $clone->request = $this->request->withoutHeader($name);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @return StreamInterface
     */
    public function getBody()
    {
        return $this->request->getBody();
    }

    /**
     * @inheritDoc
     *
     * @param StreamInterface $body
     * @return static
     */
    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->request = $this->request->withBody($body);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getRequestTarget()
    {
        return $this->request->getRequestTarget();
    }

    /**
     * @inheritDoc
     *
     * @param mixed $requestTarget
     * @return static
     */
    public function withRequestTarget($requestTarget)
    {
        $clone = clone $this;
        $clone->request = $this->request->withRequestTarget($requestTarget);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->request->getMethod();
    }

    /**
     * @inheritDoc
     *
     * @param string $method
     * @return static
     */
    public function withMethod($method)
    {
        $clone = clone $this;
        $clone->request = $this->request->withMethod($method);

        return $clone;
    }

    /**
     * @inheritDoc
     *
     * @return UriInterface
     */
    public function getUri()
    {
        return $this->request->getUri();
    }

    /**
     * @inheritDoc
     *
     * @param UriInterface $uri
     * @param bool $preserveHost
     * @return static
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $clone = clone $this;
        $clone->request = $this->request->withUri($uri, $preserveHost);

        return $clone;
    }
}
