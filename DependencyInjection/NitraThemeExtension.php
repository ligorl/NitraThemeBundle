<?php

namespace Nitra\NitraThemeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class NitraThemeExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('admingenerator.fieldguesser.doctrine.class', 'Nitra\NitraThemeBundle\Guesser\NitraFieldGuesser');
    
        // Используем свой класс для исправления ошибки при фильтрации по списку обьектов (в BETA4)
        $container->setParameter('admingenerator.queryfilter.doctrine.class', 'Nitra\NitraThemeBundle\QueryFilter\NitraDoctrineQueryFilter');
    }

    public function getAlias()
    {
        return 'nitra_theme';
    }

}
