<?php

/**
 * This file is part of shopery/view-bundle
 *
 * Copyright (c) 2016 Shopery.com
 */

namespace Shopery\Bundle\ViewBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Shopery\Bundle\ViewBundle\DependencyInjection\Compiler\RegisterViewFactories;
use Shopery\Bundle\ViewBundle\Extension\ViewExtension;

/**
 * Class ViewBundle
 */
class ViewBundle extends Bundle
{
    public function __construct()
    {
        $this->name = 'ShoperyViewBundle';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterViewFactories());
    }

    protected function createContainerExtension()
    {
        return new ViewExtension();
    }
}
