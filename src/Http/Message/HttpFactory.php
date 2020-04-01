<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

class HttpFactory implements HttpFactoryInterface
{
    use Concerns\RequestFactory;
    use Concerns\ResponseFactory;
    use Concerns\ServerRequestFactory;
    use Concerns\StreamFactory;
    use Concerns\UploadedFileFactory;
    use Concerns\UriFactory;
}
