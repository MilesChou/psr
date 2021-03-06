<?php

declare(strict_types=1);

namespace MilesChou\Psr\Container;

use Psr\Container\ContainerInterface;

/**
 * Basic Implementation of ContainerAwareInterface.
 */
trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @return $this
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
    }
}
