<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Traits;

use DomainException;
use Http\Factory\Guzzle\ResponseFactory as GuzzleFactory;
use Http\Factory\Slim\ResponseFactory as SlimFactory;
use Laminas\Diactoros\ResponseFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

trait ResponseFactoryDetector
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @return ResponseFactoryInterface
     */
    public static function resolveResponseFactory(): ResponseFactoryInterface
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

        throw new DomainException('ResponseFactory driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory()->createResponse($code, $reasonPhrase);
    }

    /**
     * @return ResponseFactoryInterface
     */
    public function responseFactory(): ResponseFactoryInterface
    {
        if ($this->responseFactory instanceof ResponseFactoryInterface) {
            return $this->responseFactory;
        }

        return self::resolveResponseFactory();
    }

    /**
     * @param ResponseFactoryInterface|null $responseFactory
     * @return static
     */
    public function setResponseFactory(?ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
        return $this;
    }
}
