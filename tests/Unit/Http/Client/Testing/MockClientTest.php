<?php

namespace Tests\Unit\Http\Client\Testing;

use Laminas\Diactoros\Request as LaminasRequest;
use Laminas\Diactoros\Response;
use MilesChou\Psr\Http\Client\Testing\MockClient;
use OutOfBoundsException;
use RuntimeException;
use Tests\TestCase;

class MockClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionWhenQueueIsEmpty(): void
    {
        $this->expectException(RuntimeException::class);

        $target = new MockClient();

        $target->sendRequest(new LaminasRequest('whatever', 'GET'));
    }

    /**
     * @test
     */
    public function shouldGetResponseInQueue(): void
    {
        $expected = new Response();

        $target = new MockClient($expected);

        $actual = $target->sendRequest(new LaminasRequest('whatever', 'GET'));

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldGetResponseAfterAppendToQueue(): void
    {
        $expected = new Response();

        $target = new MockClient();
        $target->appendQueueList([$expected]);

        $actual = $target->sendRequest(new LaminasRequest('whatever', 'GET'));

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldGetEmptyResponseWhenAppendEmpty(): void
    {
        $target = new MockClient();
        $target->appendEmptyResponse();

        $actual = $target->sendRequest(new LaminasRequest('whatever', 'GET'));

        $this->assertSame(200, $actual->getStatusCode());
        $this->assertSame('', (string)$actual->getBody());
    }

    /**
     * @test
     */
    public function shouldGetResponseWithString(): void
    {
        $target = new MockClient();
        $target->appendResponseWith('Hello', 201, ['foo' => 'bar']);

        $actual = $target->sendRequest(new LaminasRequest('whatever', 'GET'));

        $this->assertSame(201, $actual->getStatusCode());
        $this->assertSame(['bar'], $actual->getHeader('foo'));
        $this->assertSame('Hello', (string)$actual->getBody());
    }

    /**
     * @test
     */
    public function shouldGetResponseWithJson(): void
    {
        $target = new MockClient();
        $target->appendResponseWithJson(['foo' => 'bar']);

        $actual = $target->sendRequest(new LaminasRequest('whatever', 'GET'));

        $this->assertSame('{"foo":"bar"}', (string)$actual->getBody());
    }

    /**
     * @test
     */
    public function shouldGetRequestInSpy(): void
    {
        $expected = new LaminasRequest('whatever', 'GET');

        $target = new MockClient(new Response());

        $target->sendRequest($expected);

        $this->assertSame($expected, $target->requests[0]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenQueueInThrowable(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Hello');

        $target = new MockClient(new \Exception('Hello'));
        $target->sendRequest(new LaminasRequest());
    }

    /**
     * @test
     */
    public function shouldCheckHasRequests(): void
    {
        $target = new MockClient();
        $target->appendEmptyResponse();

        $this->assertFalse($target->hasRequests());

        $target->sendRequest(new LaminasRequest());

        $this->assertTrue($target->hasRequests());
    }

    /**
     * @test
     */
    public function shouldReturnTestRequest(): void
    {
        $target = MockClient::createAlwaysReturnEmptyResponse();

        $target->sendRequest(new LaminasRequest('somewhere', 'POST'));

        $target->testRequest()->assertMethod('POST');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenRequestIsEmpty(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $target = new MockClient();

        $target->testRequest();
    }

    /**
     * @test
     */
    public function shouldAlwaysReturnEmptyResponse(): void
    {
        $target = MockClient::createAlwaysReturnEmptyResponse();

        $actual = $target->sendRequest(new LaminasRequest());

        $this->assertSame(200, $actual->getStatusCode());
    }
}
