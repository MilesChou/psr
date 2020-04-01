<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Concerns;

use DomainException;
use Laminas\Diactoros\StreamFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

trait StreamFactory
{
    /**
     * @var string
     */
    protected $streamFactoryClass = '';

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @return StreamFactoryInterface
     */
    public static function resolveStreamFactory(): StreamFactoryInterface
    {
        if (class_exists(LaminasFactory::class)) {
            return new LaminasFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('StreamFactory driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createStream(string $content = ''): StreamInterface
    {
        return $this->streamFactory()->createStream($content);
    }

    /**
     * @return StreamFactoryInterface
     */
    public function streamFactory(): StreamFactoryInterface
    {
        if ($this->streamFactory instanceof StreamFactoryInterface) {
            return $this->streamFactory;
        }

        if (class_exists($this->streamFactoryClass)) {
            $class = $this->streamFactoryClass;

            return $this->streamFactory = new $class();
        }

        return self::resolveStreamFactory();
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = self::resolveStreamFactory();
        }

        return $this->streamFactory->createStreamFromFile($filename, $mode);
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = self::resolveStreamFactory();
        }

        return $this->streamFactory->createStreamFromResource($resource);
    }

    /**
     * @param StreamFactoryInterface $streamFactory
     * @return $this
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->streamFactory = $streamFactory;
        return $this;
    }
}
