<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\ResponseFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    use Concerns\ResponseFactory;
}
