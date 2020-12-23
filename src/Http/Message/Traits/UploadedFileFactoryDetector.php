<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message\Traits;

use DomainException;
use Http\Factory\Guzzle\UploadedFileFactory as GuzzleFactory;
use Http\Factory\Slim\UploadedFileFactory as SlimFactory;
use Laminas\Diactoros\UploadedFileFactory as LaminasFactory;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmFactory;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;

trait UploadedFileFactoryDetector
{
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

        if (class_exists(GuzzleFactory::class)) {
            return new GuzzleFactory();
        }

        if (class_exists(SlimFactory::class)) {
            return new SlimFactory();
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

        return self::resolveUploadedFileFactory();
    }

    /**
     * @param UploadedFileFactoryInterface|null $uploadedFileFactory
     * @return static
     */
    public function setUploadedFileFactory(?UploadedFileFactoryInterface $uploadedFileFactory)
    {
        $this->uploadedFileFactory = $uploadedFileFactory;
        return $this;
    }
}
