<?php

namespace Tapinfort\RecaptchaBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// charger ma configuration du fichier configuration.php
class RecaptchaExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     * 
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // charger le fichier qui contient les services
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('recaptcha.key', $config['key']);
        $container->setParameter('recaptcha.secret', $config['secret']);

    }
    
}