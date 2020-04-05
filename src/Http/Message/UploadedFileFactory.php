<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\UploadedFileFactoryInterface;

class UploadedFileFactory implements UploadedFileFactoryInterface
{
    use Traits\UploadedFileFactoryDetector;

    /**
     * @param UploadedFileFactoryInterface|null $factory
     */
    public function __construct($factory = null)
    {
        $this->setUploadedFileFactory($factory);
    }
}
