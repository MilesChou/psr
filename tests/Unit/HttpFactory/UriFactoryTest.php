<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\Http\Message\UriFactory;
use Psr\Http\Message\UriFactoryInterface;
use Tests\TestCase;

class UriFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnUriFactory(): void
    {
        $actual = UriFactory::resolveUriFactory();

        $this->assertInstanceOf(UriFactoryInterface::class, $actual);
    }
}
