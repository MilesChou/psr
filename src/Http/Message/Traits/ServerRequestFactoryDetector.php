<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Traits;

use DomainException;
use Http\Factory\Guzzle\ServerRequestFactory as GuzzleFactory;
use Http\Factory\Slim\ServerRequestFactory as SlimFactory;
use Laminas\Diactoros\ServerRequestFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

trait ServerRequestFactoryDetector
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

        if (class_exists(GuzzleFactory::class)) {
            return new GuzzleFactory();
        }

        if (class_exists(SlimFactory::class)) {
            return new SlimFactory();
        }

        throw new DomainException('ServerRequestFactory driver is not found');
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
     * @param ServerRequestFactoryInterface|null $serverRequestFactory
     * @return static
     */
    public function setServerRequestFactory(?ServerRequestFactoryInterface $serverRequestFactory)
    {
        $this->serverRequestFactory = $serverRequestFactory;
        return $this;
    }
}
