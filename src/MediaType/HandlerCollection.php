<?php

namespace bitbirddev\TwigComponentsBundle\MediaType;

class HandlerCollection
{
    public function __construct(
        protected iterable $handlers
    ) {
    }
    public function match($video): ?HandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler::supports($video)) {
                return $handler::make($video);
            }
        }
        return null;
    }
}
