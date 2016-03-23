<?php

/**
 * This file is part of shopery/view-bundle
 *
 * Copyright (c) 2016 Shopery.com
 */

namespace Shopery\Bundle\ViewBundle\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class ViewExtension
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ViewExtension extends Extension
{
    public function getAlias()
    {
        return 'shopery_view';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yml');
    }
}
