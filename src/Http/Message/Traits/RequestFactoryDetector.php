<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Traits;

use DomainException;
use Http\Factory\Guzzle\RequestFactory as GuzzleFactory;
use Http\Factory\Slim\RequestFactory as SlimFactory;
use Laminas\Diactoros\RequestFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

trait RequestFactoryDetector
{
    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @return RequestFactoryInterface
     */
    public static function resolveRequestFactory(): RequestFactoryInterface
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

        throw new DomainException('RequestFactory driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        return $this->requestFactory()->createRequest($method, $uri);
    }

    /**
     * @return RequestFactoryInterface
     */
    public function requestFactory(): RequestFactoryInterface
    {
        if ($this->requestFactory instanceof RequestFactoryInterface) {
            return $this->requestFactory;
        }

        return self::resolveRequestFactory();
    }

    /**
     * @param RequestFactoryInterface|null $requestFactory
     * @return static
     */
    public function setRequestFactory(?RequestFactoryInterface $requestFactory)
    {
        $this->requestFactory = $requestFactory;
        return $this;
    }
}
