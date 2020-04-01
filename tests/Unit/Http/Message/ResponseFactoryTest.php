<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use Laminas\Diactoros\Response as LaminasResponse;
use Laminas\Diactoros\ResponseFactory as LaminasResponseFactory;
use MilesChou\Psr\Http\Message\ResponseFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Nyholm\Psr7\Response as NyholmResponse;
use Psr\Http\Message\ResponseFactoryInterface;
use Tests\Fixtures\Psr17\TestResponseFactory;
use Tests\TestCase;

class ResponseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnResponseFactory(): void
    {
        $target = new ResponseFactory();

        $this->assertInstanceOf(ResponseFactoryInterface::class, $target->responseFactory());
    }

    /**
     * @test
     */
    public function shouldReturnSpecifyInstance(): void
    {
        $target = new ResponseFactory();
        $target->setResponseFactory(new NyholmFactory());

        $this->assertInstanceOf(NyholmFactory::class, $target->responseFactory());
        $this->assertInstanceOf(NyholmResponse::class, $target->createResponse());
    }
}
