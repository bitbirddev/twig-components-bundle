<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;

class AssetVideoHandler extends AbstractHandler
{
    public function __construct(protected ?\Pimcore\Model\Asset\Video $asset)
    {
    }

    public static function supports($arg): bool
    {
        return $arg instanceof \Pimcore\Model\Asset\Video;
    }

    public static function make(\Pimcore\Model\Asset\Video $asset): HandlerInterface
    {
        return new self($asset);
    }

    public function getTitle(): ?string
    {
        return $this->asset->getMetadata("title");
    }

    public function getCopyright(): ?string
    {
        return $this->asset->getMetadata("copyright");
    }

    public function getSources(): array
    {
        return $this->getAssetVideoThumbnail($this->asset);
    }

    public function getPoster(): ?string
    {
        return $this->asset->getImageThumbnail($this->posterThumbnailName)->getFrontendPath();
    }

}
