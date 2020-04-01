<?php

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\StreamFactoryInterface;

class StreamFactory implements StreamFactoryInterface
{
    use Concerns\StreamFactory;
}
