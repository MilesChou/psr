<?php

namespace Tests\Unit\Http\Message\Testing;

use BadMethodCallException;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\StreamFactory;
use MilesChou\Psr\Http\Message\Testing\TestRequest;
use Tests\TestCase;

class TestRequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCheckAssertRequest(): void
    {
        $request = (new Request('http://somewhere/here', 'POST'))
            ->withHeader('Foo', 'Bar')
            ->withHeader('Authorization', 'Basic dXNlcjpwYXNz')
            ->withHeader('Content-type', 'application/json; charset=UTF-8')
            ->withBody((new StreamFactory())->createStream('Hello'));

        $target = TestRequest::fromBaseRequest($request);

        $target->assertProtocolVersion('1.1')
            ->assertMethod('POST')
            ->assertUriContains('where')
            ->assertUri('http://somewhere/here')
            ->assertRequestTarget('/here')
            ->assertHeader('Foo')
            ->assertHeader('Foo', 'Bar')
            ->assertHeaderMissing('None')
            ->assertBasicAuthentication('user', 'pass')
            ->assertContentTypeIsJson()
            ->assertBodyContains('Hello');
    }

    /**
     * @test
     */
    public function shouldReturnBaseRequestContent(): void
    {
        $target = new TestRequest(new Request(null, 'GET'));

        $this->assertSame('GET', $target->getMethod());
    }
}
