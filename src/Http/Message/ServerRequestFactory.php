<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\ServerRequestFactoryInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    use Concerns\ServerRequestFactory;

    /**
     * @param ServerRequestFactoryInterface|null $factory
     */
    public function __construct($factory = null)
    {
        $this->setServerRequestFactory($factory);
    }
}
