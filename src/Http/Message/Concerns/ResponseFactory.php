<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Concerns;

use DomainException;
use Laminas\Diactoros\ResponseFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

trait ResponseFactory
{
    /**
     * @var string
     */
    protected $responseFactoryClass;

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

        if (class_exists($this->responseFactoryClass)) {
            $class = $this->responseFactoryClass;

            return $this->responseFactory = new $class();
        }

        return self::resolveResponseFactory();
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
