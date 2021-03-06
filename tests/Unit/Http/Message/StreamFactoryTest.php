<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use MilesChou\Psr\Http\Message\StreamFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Nyholm\Psr7\Stream as NyholmStream;
use Psr\Http\Message\StreamFactoryInterface;
use Tests\TestCase;

class StreamFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnStreamFactory(): void
    {
        $target = new StreamFactory();

        $this->assertInstanceOf(StreamFactoryInterface::class, $target->streamFactory());
    }

    /**
     * @test
     */
    public function shouldReturnSpecifyInstance(): void
    {
        $target = new StreamFactory();
        $target->setStreamFactory(new NyholmFactory());

        $this->assertInstanceOf(NyholmFactory::class, $target->streamFactory());
        $this->assertInstanceOf(NyholmStream::class, $target->createStream());
    }
}
