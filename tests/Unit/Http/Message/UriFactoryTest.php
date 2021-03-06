<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use MilesChou\Psr\Http\Message\UriFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Nyholm\Psr7\Uri as NyholmUri;
use Psr\Http\Message\UriFactoryInterface;
use Tests\TestCase;

class UriFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnUriFactory(): void
    {
        $target = new UriFactory();

        $this->assertInstanceOf(UriFactoryInterface::class, $target->uriFactory());
    }

    /**
     * @test
     */
    public function shouldReturnSpecifyInstance(): void
    {
        $target = new UriFactory();
        $target->setUriFactory(new NyholmFactory());

        $this->assertInstanceOf(NyholmFactory::class, $target->uriFactory());
        $this->assertInstanceOf(NyholmUri::class, $target->createUri());
    }
}
