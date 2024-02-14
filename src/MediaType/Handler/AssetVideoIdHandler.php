<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;

class AssetVideoIdHandler extends AbstractHandler
{
    public function __construct(protected ?\Pimcore\Model\Asset\Video $asset)
    {
    }

    public static function supports($arg): bool
    {
        if(!is_int($arg)) {
            return false;
        }

        if(!$video = \Pimcore\Model\Asset\Video::getById($arg)) {
            return false;
        }

        return true;
    }

    public static function make(int $id): HandlerInterface
    {
        return new self(\Pimcore\Model\Asset\Video::getById($id));
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
