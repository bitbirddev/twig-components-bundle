<?php

namespace bitbirddev\TwigComponentsBundle\MediaType;

interface HandlerInterface
{
    public static function supports($video): bool;
}
