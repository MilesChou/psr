<?php

declare(strict_types=1);

namespace Tests\Fixtures\Psr17;

use Laminas\Diactoros\UploadedFileFactory as LaminasUploadedFileFactory;
use MilesChou\Psr\Http\Message\UploadedFileFactory;

class TestUploadedFileFactory extends UploadedFileFactory
{
    protected $uploadedFileFactoryClass = LaminasUploadedFileFactory::class;
}
