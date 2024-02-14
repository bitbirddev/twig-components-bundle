<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;

class SourceArrayHandler extends AbstractHandler
{
    public function __construct(protected ?array $sources = [])
    {
    }

    public static function supports($arg): bool
    {
        return is_array($arg);
    }
    /**
     * @param array<int,mixed> $sources
     */
    public static function make(array $sources): HandlerInterface
    {
        return new self($sources);
    }

    public function getSources(): array
    {
        return $this->sources;
    }

    public function getConsents(): array
    {

        // we dont know which sources are provided
        return [];
    }

}
