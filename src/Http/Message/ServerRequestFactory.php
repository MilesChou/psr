<?php

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\ServerRequestFactoryInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    use Concerns\ServerRequestFactory;
}
