<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use Laminas\Diactoros\ServerRequest as LaminasServerRequest;
use Laminas\Diactoros\ServerRequestFactory as LaminasServerRequestFactory;
use MilesChou\Psr\Http\Message\ServerRequestFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Nyholm\Psr7\ServerRequest as NyholmServerRequest;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Tests\Fixtures\Psr17\TestServerRequestFactory;
use Tests\TestCase;

class ServerRequestFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnServerRequestFactory(): void
    {
        $target = new ServerRequestFactory();

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $target->serverRequestFactory());
    }

    /**
     * @test
     */
    public function shouldReturnSpecifyInstance(): void
    {
        $target = new ServerRequestFactory();
        $target->setServerRequestFactory(new NyholmFactory());

        $this->assertInstanceOf(NyholmFactory::class, $target->serverRequestFactory());
        $this->assertInstanceOf(NyholmServerRequest::class, $target->createServerRequest('GET', 'whatever'));
    }

    /**
     * @test
     */
    public function shouldReturnSpecifyClass(): void
    {
        $target = new TestServerRequestFactory();

        $this->assertInstanceOf(LaminasServerRequestFactory::class, $target->serverRequestFactory());
        $this->assertInstanceOf(LaminasServerRequest::class, $target->createServerRequest('GET', 'whatever'));
    }
}
