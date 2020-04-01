<?php

namespace Tests\Fixtures\Psr17;

use Laminas\Diactoros\StreamFactory as LaminasStreamFactory;
use MilesChou\Psr\Http\Message\StreamFactory;

class TestStreamFactory extends StreamFactory
{
    protected $streamFactoryClass = LaminasStreamFactory::class;
}
