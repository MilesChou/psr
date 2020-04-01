<?php

namespace Tests\Fixtures\Psr17;

use Laminas\Diactoros\RequestFactory as LaminasRequestFactory;
use MilesChou\Psr\Http\Message\RequestFactory;

class TestRequestFactory extends RequestFactory
{
    protected $requestFactoryClass = LaminasRequestFactory::class;
}
