<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Concerns;

use DomainException;
use Laminas\Diactoros\RequestFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

trait RequestFactory
{
    /**
     * @var string
     */
    protected $requestFactoryClass = '';

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

        if (class_exists($this->requestFactoryClass)) {
            $class = $this->requestFactoryClass;

            return $this->requestFactory = new $class();
        }

        return self::resolveRequestFactory();
    }

    /**
     * @param RequestFactoryInterface $requestFactory
     * @return $this
     */
    public function setRequestFactory(?RequestFactoryInterface $requestFactory): self
    {
        $this->requestFactory = $requestFactory;
        return $this;
    }
}
