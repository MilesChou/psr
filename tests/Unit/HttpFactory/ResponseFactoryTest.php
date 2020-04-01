<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\Http\Message\ResponseFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Tests\TestCase;

class ResponseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnResponseFactory(): void
    {
        $actual = ResponseFactory::resolveResponseFactory();

        $this->assertInstanceOf(ResponseFactoryInterface::class, $actual);
    }
}
