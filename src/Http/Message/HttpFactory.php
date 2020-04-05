<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

class HttpFactory implements HttpFactoryInterface
{
    use Traits\RequestFactoryDetector;
    use Traits\ResponseFactoryDetector;
    use Traits\ServerRequestFactoryDetector;
    use Traits\StreamFactoryDetector;
    use Traits\UploadedFileFactoryDetector;
    use Traits\UriFactoryDetector;
}
