<?php

declare(strict_types=1);

namespace MilesChou\Psr\Container;

use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container);
}
