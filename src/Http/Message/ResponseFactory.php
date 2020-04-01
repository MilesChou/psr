<?php

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\ResponseFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    use Concerns\ResponseFactory;
}
