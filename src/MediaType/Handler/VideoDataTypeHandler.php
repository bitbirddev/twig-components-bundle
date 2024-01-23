<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\YoutubeHelper;

class VideoDataTypeHandler extends AbstractHandler
{
    public function __construct(protected ?\Pimcore\Model\DataObject\Data\Video $video)
    {
    }

    public static function supports($video): bool
    {
        return $video instanceof \Pimcore\Model\DataObject\Data\Video;
    }

    public static function make(\Pimcore\Model\DataObject\Data\Video $video): HandlerInterface
    {
        return new self($video);
    }

    // only when "asset" is selected in the backend you can enter a title
    public function getTitle(): ?string
    {
        return match($this->video->getType()) {
            "youtube" => null,
            "vimeo" => null,
            "asset" => $this->video->getTitle(),
            default => null
        };
    }

    // only when "asset" is selected in the backend you can enter a description
    public function getDescription(): ?string
    {
        return match($this->video->getType()) {
            "youtube" => null,
            "vimeo" => null,
            "asset" => $this->video->getDescription(),
            default => null
        };
    }


    public function getSources(): array
    {
        /** @var \Pimcore\Model\DataObject\Data\Video  $video */
        $video = $this->video;
        $type = $video->getType();
        $data = $video->getData();

        return  match($video->getType()) {
            "youtube" => [["type" => "video/youtube", "src" => YoutubeHelper::createEmbedUrl($data)]],
            "vimeo" => [["type" => "video/vimeo", "src" => VimeoHelper::createEmbedUrl($data)]],
            "asset" => $this->getAssetVideoThumbnail($data),
            default => []
        };
    }

    public function getPoster(): ?string
    {
        return match($this->video->getType()) {
            "youtube" => null,
            "vimeo" => null,
            "asset" => $this->video->getPoster() ? $this->video->getPoster()->getThumbnail($this->posterThumbnailName)->getFrontendPath() : null,
            default => null
        };
    }

    public function getConsents(): array
    {
        return match($this->video->getType()) {
            "youtube" => ['BJz7qNsdj-7'],
            "vimeo" => ['HyEX5Nidi-m'],
            "asset" => [],
            default => []
        };
    }
}
