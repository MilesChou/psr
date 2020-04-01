<?php

namespace Tests\Fixtures\Psr17;

use Laminas\Diactoros\ResponseFactory as LaminasResponseFactory;
use MilesChou\Psr\Http\Message\ResponseFactory;

class TestResponseFactory extends ResponseFactory
{
    protected $responseFactoryClass = LaminasResponseFactory::class;
}
