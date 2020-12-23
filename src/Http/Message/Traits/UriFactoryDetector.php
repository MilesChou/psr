<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Traits;

use DomainException;
use Http\Factory\Guzzle\UriFactory as GuzzleFactory;
use Http\Factory\Slim\UriFactory as SlimFactory;
use Laminas\Diactoros\UriFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

trait UriFactoryDetector
{
    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @return UriFactoryInterface
     */
    public static function resolveUriFactory(): UriFactoryInterface
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

        throw new DomainException('UriFactory driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createUri(string $uri = ''): UriInterface
    {
        return $this->uriFactory()->createUri($uri);
    }

    /**
     * @return UriFactoryInterface
     */
    public function uriFactory(): UriFactoryInterface
    {
        if ($this->uriFactory instanceof UriFactoryInterface) {
            return $this->uriFactory;
        }

        return self::resolveUriFactory();
    }

    /**
     * @param UriFactoryInterface|null $uriFactory
     * @return static
     */
    public function setUriFactory(?UriFactoryInterface $uriFactory)
    {
        $this->uriFactory = $uriFactory;
        return $this;
    }
}
