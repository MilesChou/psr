<?php

declare(strict_types=1);

namespace MilesChou\Psr\HttpFactory\Concerns;

use DomainException;
use Laminas\Diactoros\StreamFactory as LaminasStreamFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

trait StreamFactory
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @return StreamFactoryInterface
     */
    public static function createStreamFactory(): StreamFactoryInterface
    {
        if (class_exists(LaminasStreamFactory::class)) {
            return new LaminasStreamFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('PSR-17 driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createStream(string $content = ''): StreamInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = self::createStreamFactory();
        }

        return $this->streamFactory->createStream($content);
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = self::createStreamFactory();
        }

        return $this->streamFactory->createStreamFromFile($filename, $mode);
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = self::createStreamFactory();
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
