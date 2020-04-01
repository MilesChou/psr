<?php

declare(strict_types=1);

namespace MilesChou\Psr\HttpFactory\Concerns;

use DomainException;
use Laminas\Diactoros\ResponseFactory as LaminasResponseFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

trait ResponseFactory
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @return ResponseFactoryInterface
     */
    public static function createResponseFactory(): ResponseFactoryInterface
    {
        if (class_exists(LaminasResponseFactory::class)) {
            return new LaminasResponseFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('PSR-17 driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        if (null === $this->responseFactory) {
            $this->responseFactory = self::createResponseFactory();
        }

        return $this->responseFactory->createResponse($code, $reasonPhrase);
    }

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @return $this
     */
    public function setResponseFactory(ResponseFactoryInterface $responseFactory): self
    {
        $this->responseFactory = $responseFactory;
        return $this;
    }
}
