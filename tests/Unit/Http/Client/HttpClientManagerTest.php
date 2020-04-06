<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Client;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use MilesChou\Psr\Http\Client\HttpClientManager;
use MilesChou\Psr\Http\Client\Testing\MockClient;
use MilesChou\Psr\Http\Message\HttpFactory;
use OutOfRangeException;
use Tests\TestCase;

class HttpClientManagerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnDefaultClient(): void
    {
        $expected = new MockClient();

        $target = new HttpClientManager($expected);

        $this->assertSame($expected, $target->driver());
    }

    /**
     * @test
     */
    public function shouldSwapDefaultClient(): void
    {
        $expected = new MockClient();

        $target = new HttpClientManager(new MockClient());
        $target->setDefault($expected);

        $this->assertSame($expected, $target->driver());
    }

    /**
     * @test
     */
    public function shouldReturnAddedDriver(): void
    {
        $expected = new MockClient();

        $target = new HttpClientManager(new MockClient());
        $target->add('hello', $expected);

        $this->assertSame($expected, $target->driver('hello'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenDriverNotFound(): void
    {
        $this->expectException(OutOfRangeException::class);

        $target = new HttpClientManager(new MockClient());

        $target->driver('not-found');
    }

    /**
     * @test
     */
    public function shouldProxyToDefaultClient(): void
    {
        $expected = new Response();

        $client = new MockClient();
        $client->appendResponse($expected);

        $target = new HttpClientManager($client);

        $this->assertSame($expected, $target->sendRequest(new Request()));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSetHttpFactory(): void
    {
        $target = new HttpClientManager(new MockClient());

        $target->setHttpFactory(null);

        $this->assertNotInstanceOf(HttpFactory::class, $target->requestFactory());
        $this->assertNotInstanceOf(HttpFactory::class, $target->responseFactory());
        $this->assertNotInstanceOf(HttpFactory::class, $target->serverRequestFactory());
        $this->assertNotInstanceOf(HttpFactory::class, $target->streamFactory());
        $this->assertNotInstanceOf(HttpFactory::class, $target->uploadedFileFactory());
        $this->assertNotInstanceOf(HttpFactory::class, $target->uriFactory());

        $target->setHttpFactory(new HttpFactory());

        $this->assertInstanceOf(HttpFactory::class, $target->requestFactory());
        $this->assertInstanceOf(HttpFactory::class, $target->responseFactory());
        $this->assertInstanceOf(HttpFactory::class, $target->serverRequestFactory());
        $this->assertInstanceOf(HttpFactory::class, $target->streamFactory());
        $this->assertInstanceOf(HttpFactory::class, $target->uploadedFileFactory());
        $this->assertInstanceOf(HttpFactory::class, $target->uriFactory());
    }
}
