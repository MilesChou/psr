<?php

namespace MilesChou\Psr\Http\Client;

use MilesChou\Psr\Http\Message\HttpFactoryInterface;
use Psr\Http\Client\ClientInterface;

interface HttpClientInterface extends ClientInterface, HttpFactoryInterface
{
}
