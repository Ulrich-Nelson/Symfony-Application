<?php
namespace Tapinfort\RecaptchaBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

// charger la configuration de mon recaptcha du yaml
class Configuration  implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('recaptcha');
        $rootNode
            ->children()
            ->scalarNode('key')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('secret')
            ->cannotBeEmpty()
            ->isRequired()
            ->end()
            ->end();

        return $treeBuilder;    

    }
    
}