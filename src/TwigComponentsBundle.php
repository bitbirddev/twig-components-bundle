<?php

declare(strict_types=1);

namespace bitbirddev\TwigComponentsBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class TwigComponentsBundle extends AbstractBundle
{
    private const CONFIG_DIR = '/config';

    private const SERVICES_FILE = 'services.yaml';

    private static string $configDir = '';

    public function getContainerExtension(): ExtensionInterface
    {
        return new TwigComponentsBundleExtension(
            self::configDir(),
            self::servicesFile()
        );
    }

    protected function getContainerExtensionClass(): string
    {
        return TwigComponentsBundleExtension::class;
    }

    public function getPath(): string
    {
        if (!$this->path) {
            $this->path = dirname(__DIR__);
        }

        return $this->path;
    }

    public static function configDir(): string
    {
        if (!self::$configDir) {
            self::$configDir = realpath(
                dirname(__DIR__) . self::CONFIG_DIR
            );
        }

        return self::$configDir;
    }

    public static function servicesFile(): string
    {
        return self::SERVICES_FILE;
    }
}
