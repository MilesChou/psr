<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\Http\Message\RequestFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Tests\TestCase;

class RequestFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnRequestFactory(): void
    {
        $actual = RequestFactory::resolveRequestFactory();

        $this->assertInstanceOf(RequestFactoryInterface::class, $actual);
    }
}
