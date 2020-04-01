<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use Laminas\Diactoros\Request as LaminasRequest;
use Laminas\Diactoros\RequestFactory as LaminasRequestFactory;
use MilesChou\Psr\Http\Message\RequestFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Nyholm\Psr7\Request as NyholmRequest;
use Psr\Http\Message\RequestFactoryInterface;
use Tests\Fixtures\Psr17\TestRequestFactory;
use Tests\TestCase;

class RequestFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnRequestFactory(): void
    {
        $target = new RequestFactory();

        $this->assertInstanceOf(RequestFactoryInterface::class, $target->requestFactory());
    }


    /**
     * @test
     */
    public function shouldReturnSpecifyInstance(): void
    {
        $target = new RequestFactory();
        $target->setRequestFactory(new NyholmFactory());

        $this->assertInstanceOf(NyholmFactory::class, $target->requestFactory());
        $this->assertInstanceOf(NyholmRequest::class, $target->createRequest('GET', 'whatever'));
    }
}
