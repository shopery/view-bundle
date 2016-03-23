<?php

/**
 * This file is part of shopery/view-bundle
 *
 * Copyright (c) 2016 Shopery.com
 */

namespace Shopery\Bundle\ViewBundle\Resolver;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Shopery\View\Extension\ViewExtension;
use Shopery\View\Extension\ViewExtensionResolver;

/**
 * Class SymfonyExtensionViewResolver
 *
 * @author Berny Cantos <be@rny.cc>
 */
class SymfonyExtensionViewResolver implements ViewExtensionResolver
{
    private $container;
    private $serviceNames;
    private $resolved = [];

    /**
     * @param ContainerInterface $container
     * @param string[][]         $serviceIdsByViewClass
     */
    public function __construct(ContainerInterface $container, $serviceIdsByViewClass)
    {
        $this->serviceNames = $serviceIdsByViewClass;
        $this->resolved = [];
        $this->container = $container;
    }

    /**
     * Returns extensions which can be applied to a view.
     *
     * @param object $object
     *
     * @return ViewExtension[]
     */
    public function resolveExtensions($object)
    {
        $class = get_class($object);
        if (!isset($this->resolved[$class])) {
            $this->resolved[$class] = $this->resolveForClass($class);
        }

        return $this->resolved[$class];
    }

    private function resolveForClass($class)
    {
        if (!isset($this->serviceNames[$class])) {
            return [];
        }

        $services = [];
        foreach ($this->serviceNames[$class] as $serviceId) {
            $services[] = $this->container->get($serviceId);
        }

        return $services;
    }
}
