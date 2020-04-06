<?php

namespace MilesChou\Psr\Http\Client;

use MilesChou\Psr\Http\Message\HttpFactoryInterface;
use MilesChou\Psr\Http\Message\Traits\RequestFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\ResponseFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\ServerRequestFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\StreamFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\UploadedFileFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\UriFactoryDetector;

class HttpClientManager extends ClientManager implements HttpClientInterface
{
    use RequestFactoryDetector;
    use ResponseFactoryDetector;
    use ServerRequestFactoryDetector;
    use StreamFactoryDetector;
    use UploadedFileFactoryDetector;
    use UriFactoryDetector;

    /**
     * @param HttpFactoryInterface $httpFactory
     * @return $this
     */
    public function setHttpFactory(HttpFactoryInterface $httpFactory): self
    {
        $this->setRequestFactory($httpFactory);
        $this->setResponseFactory($httpFactory);
        $this->setServerRequestFactory($httpFactory);
        $this->setStreamFactory($httpFactory);
        $this->setUploadedFileFactory($httpFactory);
        $this->setUriFactory($httpFactory);

        return $this;
    }
}
