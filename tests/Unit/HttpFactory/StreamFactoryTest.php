<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\Http\Message\StreamFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Tests\TestCase;

class StreamFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnStreamFactory(): void
    {
        $actual = StreamFactory::resolveStreamFactory();

        $this->assertInstanceOf(StreamFactoryInterface::class, $actual);
    }
}
