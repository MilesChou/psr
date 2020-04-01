<?php

declare(strict_types=1);

namespace MilesChou\Psr\HttpFactory\Concerns;

use DomainException;
use Laminas\Diactoros\UriFactory as LaminasUriFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

trait UriFactory
{
    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @return UriFactoryInterface
     */
    public static function createUriFactory(): UriFactoryInterface
    {
        if (class_exists(LaminasUriFactory::class)) {
            return new LaminasUriFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('PSR-17 driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createUri(string $uri = ''): UriInterface
    {
        if (null === $this->uriFactory) {
            $this->uriFactory = self::createUriFactory();
        }

        return $this->uriFactory->createUri($uri);
    }

    /**
     * @param UriFactoryInterface $uriFactory
     * @return $this
     */
    public function setUriFactory(UriFactoryInterface $uriFactory): self
    {
        $this->uriFactory = $uriFactory;
        return $this;
    }
}
