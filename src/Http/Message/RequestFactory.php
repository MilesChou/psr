<?php

declare(strict_types=1);

namespace MilesChou\Psr\Http\Message;

use Psr\Http\Message\RequestFactoryInterface;

class RequestFactory implements RequestFactoryInterface
{
    use Concerns\RequestFactory;

    /**
     * @param RequestFactoryInterface|null $factory
     */
    public function __construct($factory = null)
    {
        $this->setRequestFactory($factory);
    }
}
