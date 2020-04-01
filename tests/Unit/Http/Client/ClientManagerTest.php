<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Client;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use MilesChou\Mocker\Psr18\MockClient;
use MilesChou\Psr\Http\Client\ClientManager;
use OutOfRangeException;
use Tests\TestCase;

class ClientManagerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnDefaultClient(): void
    {
        $expected = new MockClient();

        $target = new ClientManager($expected);

        $this->assertSame($expected, $target->driver());
    }

    /**
     * @test
     */
    public function shouldSwapDefaultClient(): void
    {
        $expected = new MockClient();

        $target = new ClientManager(new MockClient());
        $target->setDefault($expected);

        $this->assertSame($expected, $target->driver());
    }

    /**
     * @test
     */
    public function shouldReturnAddedDriver(): void
    {
        $expected = new MockClient();

        $target = new ClientManager(new MockClient());
        $target->add('hello', $expected);

        $this->assertSame($expected, $target->driver('hello'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenDriverNotFound(): void
    {
        $this->expectException(OutOfRangeException::class);

        $target = new ClientManager(new MockClient());

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

        $target = new ClientManager($client);

        $this->assertSame($expected, $target->sendRequest(new Request()));
    }
}
