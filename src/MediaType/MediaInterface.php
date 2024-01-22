<?php

namespace bitbirddev\TwigComponentsBundle\MediaType;

interface MediaInterface
{
    public function getTitle(): ?string;
    public function getDescription(): ?string;
    public function getCopyright(): ?string;

    public function getSources(): array;
    public function getPoster(): ?string;
    public function getConsents(): array;
}
