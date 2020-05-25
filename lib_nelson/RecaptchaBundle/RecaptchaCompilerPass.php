<?php


namespace Tapinfort\RecaptchaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;



class RecaptchaCompilerPass implements CompilerPassInterface {

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('twig.form.resources')) {
            $resources = $container->getParameter('twig.form.resources') ?: [];
            array_unshift($resources, '@Recaptcha/fields.html.twig');
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}