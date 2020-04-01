<?php

namespace Tests\Fixtures\Psr17;

use Laminas\Diactoros\ServerRequestFactory as LaminasServerRequestFactory;
use MilesChou\Psr\Http\Message\ServerRequestFactory;

class TestServerRequestFactory extends ServerRequestFactory
{
    protected $serverRequestFactoryClass = LaminasServerRequestFactory::class;
}
