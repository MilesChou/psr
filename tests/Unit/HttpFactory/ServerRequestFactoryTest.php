<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\Http\Message\ServerRequestFactory;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Tests\TestCase;

class ServerRequestFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnServerRequestFactory(): void
    {
        $actual = ServerRequestFactory::resolveServerRequestFactory();

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $actual);
    }
}
