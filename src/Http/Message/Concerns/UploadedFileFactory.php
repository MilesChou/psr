<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Concerns;

use DomainException;
use Laminas\Diactoros\UploadedFileFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriFactoryInterface;

trait UploadedFileFactory
{
    /**
     * @var string
     */
    protected $uploadedFileFactoryClass = '';

    /**
     * @var UploadedFileFactoryInterface
     */
    private $uploadedFileFactory;

    /**
     * @return UploadedFileFactoryInterface
     */
    public static function resolveUploadedFileFactory(): UploadedFileFactoryInterface
    {
        if (class_exists(LaminasFactory::class)) {
            return new LaminasFactory();
        }

        if (class_exists(NyholmFactory::class)) {
            return new NyholmFactory();
        }

        throw new DomainException('UploadedFileFactory driver is not found');
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
        return $this->uploadedFileFactory()->createUploadedFile(
            $stream,
            $size,
            $error,
            $clientFilename,
            $clientMediaType
        );
    }

    /**
     * @return UploadedFileFactoryInterface
     */
    public function uploadedFileFactory(): UploadedFileFactoryInterface
    {
        if ($this->uploadedFileFactory instanceof UploadedFileFactoryInterface) {
            return $this->uploadedFileFactory;
        }

        if (class_exists($this->uploadedFileFactoryClass)) {
            $class = $this->uploadedFileFactoryClass;

            return $this->uploadedFileFactory = new $class();
        }

        return self::resolveUploadedFileFactory();
    }

    /**
     * @param UploadedFileFactoryInterface $uploadedFileFactory
     * @return $this
     */
    public function setUploadedFileFactory(?UploadedFileFactoryInterface $uploadedFileFactory): self
    {
        $this->uploadedFileFactory = $uploadedFileFactory;
        return $this;
    }
}
