<?php

declare(strict_types=1);

namespace MilesChou\Psr\HttpFactory\Concerns;

use DomainException;
use Laminas\Diactoros\UploadedFileFactory as LaminasUploadedFileFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;

trait UploadedFileFactory
{
    /**
     * @var UploadedFileFactoryInterface
     */
    private $uploadedFileFactory;

    /**
     * @return UploadedFileFactoryInterface
     */
    public static function createUploadedFileFactory(): UploadedFileFactoryInterface
    {
        if (class_exists(LaminasUploadedFileFactory::class)) {
            return new LaminasUploadedFileFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('PSR-17 driver is not found');
    }

    /**
     * @inheritDoc
     */
    public function createUploadedFile(
        StreamInterface $stream,
        int $size = null,
        int $error = \UPLOAD_ERR_OK,
        string $clientFilename = null,
        string $clientMediaType = null
    ): UploadedFileInterface {
        if (null === $this->uploadedFileFactory) {
            $this->uploadedFileFactory = self::createUploadedFileFactory();
        }

        return $this->uploadedFileFactory->createUploadedFile(
            $stream,
            $size,
            $error,
            $clientFilename,
            $clientMediaType
        );
    }

    /**
     * @param UploadedFileFactoryInterface $uploadedFileFactory
     * @return $this
     */
    public function setUploadedFileFactory(UploadedFileFactoryInterface $uploadedFileFactory): self
    {
        $this->uploadedFileFactory = $uploadedFileFactory;
        return $this;
    }
}
