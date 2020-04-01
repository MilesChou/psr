<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Concerns;

use DomainException;
use Laminas\Diactoros\ServerRequestFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

trait ServerRequestFactory
{
    /**
     * @var ServerRequestFactoryInterface
     */
    private $serverRequestFactory;

    /**
     * @return ServerRequestFactoryInterface
     */
    public static function resolveServerRequestFactory(): ServerRequestFactoryInterface
    {
        if (class_exists(LaminasFactory::class)) {
            return new LaminasFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('PSR-17 driver is not found');
    }

    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array<mixed> $serverParams
     * @return ServerRequestInterface
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        if (null === $this->serverRequestFactory) {
            $this->serverRequestFactory = self::resolveServerRequestFactory();
        }

        return $this->serverRequestFactory->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * @return ServerRequestFactoryInterface
     */
    public function serverRequestFactory(): ServerRequestFactoryInterface
    {
        if ($this->serverRequestFactory instanceof ServerRequestFactoryInterface) {
            return $this->serverRequestFactory;
        }

        return self::resolveServerRequestFactory();
    }

    /**
     * @param ServerRequestFactoryInterface $serverRequestFactory
     * @return $this
     */
    public function setServerRequestFactory(?ServerRequestFactoryInterface $serverRequestFactory): self
    {
        $this->serverRequestFactory = $serverRequestFactory;
        return $this;
    }
}
