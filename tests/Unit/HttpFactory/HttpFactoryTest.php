<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\HttpFactory\HttpFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Tests\TestCase;

class HttpFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnRequestFactory(): void
    {
        $actual = HttpFactory::createRequestFactory();

        $this->assertInstanceOf(RequestFactoryInterface::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnResponseFactory(): void
    {
        $actual = HttpFactory::createResponseFactory();

        $this->assertInstanceOf(ResponseFactoryInterface::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnServerRequestFactory(): void
    {
        $actual = HttpFactory::createServerRequestFactory();

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnStreamFactory(): void
    {
        $actual = HttpFactory::createStreamFactory();

        $this->assertInstanceOf(StreamFactoryInterface::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnUploadedFileFactory(): void
    {
        $actual = HttpFactory::createUploadedFileFactory();

        $this->assertInstanceOf(UploadedFileFactoryInterface::class, $actual);
    }

    /**
     * @test
     */
    public function shouldReturnUriFactory(): void
    {
        $actual = HttpFactory::createUriFactory();

        $this->assertInstanceOf(UriFactoryInterface::class, $actual);
    }
}
