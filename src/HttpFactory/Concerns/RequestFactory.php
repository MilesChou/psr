<?php

declare(strict_types=1);

namespace MilesChou\Psr\HttpFactory\Concerns;

use DomainException;
use Laminas\Diactoros\RequestFactory as LaminasRequestFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

trait RequestFactory
{
    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @return RequestFactoryInterface
     */
    public static function createRequestFactory(): RequestFactoryInterface
    {
        if (class_exists(LaminasRequestFactory::class)) {
            return new LaminasRequestFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('PSR-17 driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = self::createRequestFactory();
        }

        return $this->requestFactory->createRequest($method, $uri);
    }

    /**
     * @param RequestFactoryInterface $requestFactory
     * @return $this
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $this->requestFactory = $requestFactory;
        return $this;
    }
}
