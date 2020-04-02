<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use Laminas\Diactoros\Request as LaminasRequest;
use MilesChou\Mocker\Psr18\MockClient;
use MilesChou\Psr\Http\Message\PendingRequest;
use Tests\TestCase;

class PendingRequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenSetAndGet(): void
    {
        $target = new PendingRequest(new LaminasRequest('http://somewhere', 'GET'));

        $target->withMethod('POST');

        $this->assertSame('GET', $target->getMethod());
        $this->assertSame('POST', $target->withMethod('POST')->getMethod());
    }

    /**
     * @test
     */
    public function shouldSendByClientWhenCallSend(): void
    {
        $expected = new LaminasRequest();

        $mockClient = MockClient::createAlwaysReturnEmptyResponse();

        $target = new PendingRequest($expected, $mockClient);
        $target->send();

        $this->assertSame($expected, $mockClient->requests[0]);
    }
}
