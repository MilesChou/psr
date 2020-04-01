<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\RequestFactoryInterface;

class RequestFactory implements RequestFactoryInterface
{
    use Concerns\RequestFactory;
}
