<?php

namespace Swapi\UIBundle;

use Akeneo\Platform\Bundle\UIBundle\DependencyInjection\Compiler\RegisterFormExtensionsPass;
use Akeneo\Platform\Bundle\UIBundle\DependencyInjection\Compiler\RegisterGenericProvidersPass;
use Akeneo\Platform\Bundle\UIBundle\DependencyInjection\Compiler\RegisterViewElementsPass;
use Akeneo\Platform\Bundle\UIBundle\DependencyInjection\Reference\ReferenceFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UIBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(new RegisterFormExtensionsPass())
            ->addCompilerPass(new RegisterViewElementsPass(new ReferenceFactory()))
            ->addCompilerPass(new RegisterGenericProvidersPass(new ReferenceFactory(), 'field'))
            ->addCompilerPass(new RegisterGenericProvidersPass(new ReferenceFactory(), 'empty_value'))
            ->addCompilerPass(new RegisterGenericProvidersPass(new ReferenceFactory(), 'form'))
            ->addCompilerPass(new RegisterGenericProvidersPass(new ReferenceFactory(), 'filter'))
        ;
    }
}
