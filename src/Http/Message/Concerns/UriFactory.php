<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Concerns;

use DomainException;
use Laminas\Diactoros\UriFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

trait UriFactory
{
    /**
     * @var string
     */
    protected $uriFactoryClass = '';

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

        throw new DomainException('PSR-17 driver is not found');
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

        if (class_exists($this->uriFactoryClass)) {
            $class = $this->uriFactoryClass;

            return $this->uriFactory = new $class();
        }

        return self::resolveUriFactory();
    }

    /**
     * @param UriFactoryInterface $uriFactory
     * @return $this
     */
    public function setUriFactory(?UriFactoryInterface $uriFactory): self
    {
        $this->uriFactory = $uriFactory;
        return $this;
    }
}
