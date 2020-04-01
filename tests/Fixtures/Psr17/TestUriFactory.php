<?php

namespace Tests\Fixtures\Psr17;

use Laminas\Diactoros\UriFactory as LaminasUriFactory;
use MilesChou\Psr\Http\Message\UriFactory;

class TestUriFactory extends UriFactory
{
    protected $uriFactoryClass = LaminasUriFactory::class;
}
