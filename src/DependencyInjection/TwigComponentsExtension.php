<?php

declare(strict_types=1);

namespace bitbirddev\TwigComponentsBundle\DependencyInjection;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class TwigComponentsExtension extends Extension
{
    public function __construct(
        private readonly string $configDir,
        private readonly string $servicesFile
    ) {
    }

    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(HandlerInterface::class)
         ->addTag('mediatype.handler')
        ;

        (new YamlFileLoader(
            $container,
            new FileLocator(
                $this->configDir
            )
        ))
            ->load($this->servicesFile)
        ;
    }
}
