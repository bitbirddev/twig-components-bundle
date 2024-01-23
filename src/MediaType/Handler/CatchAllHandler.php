<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(-1, -1)]
class CatchAllHandler extends AbstractHandler
{
    public function __construct()
    {
    }

    public static function supports($arg): bool
    {
        return true;
    }
    public static function make($arg): HandlerInterface
    {
        return new self();
    }

    public function getSources(): array
    {
        return [];
    }

    public function getConsents(): array
    {
        // we dont know which sources are provided
        return [];
    }
}
