<?php

namespace Nitra\NitraThemeBundle;

use Nitra\NitraThemeBundle\DependencyInjection\Compiler\FormCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NitraThemeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormCompilerPass());
    }
}
