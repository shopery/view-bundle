<?php

/**
 * This file is part of shopery/view-bundle
 *
 * Copyright (c) 2016 Shopery.com
 */

namespace Shopery\Bundle\ViewBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class RegisterViewExtensions
 *
 * @author Berny Cantos <be@rny.cc>
 */
class RegisterViewExtensions implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $resolverId = 'view_factory.extension_resolver';
        if (!$container->has($resolverId)) {
            return;
        }

        $extensions = $this->findExtensions(
            $container,
            'view_factory.extension',
            'Shopery\View\Extension\ViewExtension'
        );

        if (empty($extensions)) {
            $container->removeDefinition($resolverId);
        } else {
            $definition = $container->getDefinition($resolverId);
            $definition->addArgument($extensions);
        }
    }

    private function findExtensions(ContainerBuilder $container, $tagName, $instanceOf)
    {
        $extensions = [];
        foreach ($container->findTaggedServiceIds($tagName) as $serviceId => $tags) {
            $this->mustImplement($container, $tagName, $serviceId, $instanceOf);

            foreach ($tags as $tag) {
                $key = $tag['class'];
                $extensions[$key][] = $serviceId;
            }
        }

        return $extensions;
    }

    private function mustImplement(ContainerBuilder $container, $tagName, $serviceId, $instanceOf)
    {
        $definition = $container->getDefinition($serviceId);
        $serviceClass = $definition->getClass();

        if (!is_a($serviceClass, $instanceOf, true)) {
            throw new InvalidArgumentException(sprintf(
                'Services marked as "%s" should implement "%s" but "%s" was found.',
                $tagName,
                $instanceOf,
                $serviceClass
            ));
        }
    }
}
