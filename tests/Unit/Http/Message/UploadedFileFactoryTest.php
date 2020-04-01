<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Message;

use Laminas\Diactoros\StreamFactory as LaminasStreamFactory;
use Laminas\Diactoros\UploadedFile as LaminasUploadedFile;
use Laminas\Diactoros\UploadedFileFactory as LaminasUploadedFileFactory;
use MilesChou\Psr\Http\Message\UploadedFileFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Nyholm\Psr7\UploadedFile as NyholmUploadedFile;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Tests\Fixtures\Psr17\TestUploadedFileFactory;
use Tests\TestCase;

class UploadedFileFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnUploadedFileFactory(): void
    {
        $target = new UploadedFileFactory();

        $this->assertInstanceOf(UploadedFileFactoryInterface::class, $target->uploadedFileFactory());
    }

    /**
     * @test
     */
    public function shouldReturnSpecifyInstance(): void
    {
        $target = new UploadedFileFactory();
        $target->setUploadedFileFactory(new NyholmFactory());

        $this->assertInstanceOf(NyholmFactory::class, $target->uploadedFileFactory());
        $this->assertInstanceOf(NyholmUploadedFile::class, $target->createUploadedFile(
            (new NyholmFactory())->createStream()
        ));
    }
}
