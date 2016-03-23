<?php

/**
 * This file is part of shopery/view-bundle
 *
 * Copyright (c) 2016 Shopery.com
 */

namespace Shopery\Bundle\ViewBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterViewFactories
 *
 * @author Berny Cantos <be@rny.cc>
 */
class RegisterViewFactories implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('view_factory.registry')) {
            return;
        }

        $factories = $this->findFactories($container, 'view_factory');

        if (!empty($factories)) {
            $registry = $container->getDefinition('view_factory.registry');
            $registry->addArgument($factories);
        }
    }

    private function findFactories(ContainerBuilder $container, $tagName)
    {
        $factories = [];
        foreach ($container->findTaggedServiceIds($tagName) as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $key = $tag['class'];
                $factories[$key] = new Reference($serviceId);
            }
        }

        return $factories;
    }
}
