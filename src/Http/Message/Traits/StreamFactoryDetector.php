<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Traits;

use DomainException;
use Http\Factory\Guzzle\StreamFactory as GuzzleFactory;
use Http\Factory\Slim\StreamFactory as SlimFactory;
use Laminas\Diactoros\StreamFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

trait StreamFactoryDetector
{
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

        if (class_exists(GuzzleFactory::class)) {
            return new GuzzleFactory();
        }

        if (class_exists(SlimFactory::class)) {
            return new SlimFactory();
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
     * @return StreamFactoryInterface
     */
    public function streamFactory(): StreamFactoryInterface
    {
        if ($this->streamFactory instanceof StreamFactoryInterface) {
            return $this->streamFactory;
        }

        return self::resolveStreamFactory();
    }

    /**
     * @param StreamFactoryInterface|null $streamFactory
     * @return static
     */
    public function setStreamFactory(?StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
        return $this;
    }
}
