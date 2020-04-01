<?php

declare(strict_types=1);

namespace Tests\Unit\HttpFactory;

use MilesChou\Psr\Http\Message\UploadedFileFactory;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Tests\TestCase;

class UploadedFileFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnUploadedFileFactory(): void
    {
        $actual = UploadedFileFactory::resolveUploadedFileFactory();

        $this->assertInstanceOf(UploadedFileFactoryInterface::class, $actual);
    }
}
