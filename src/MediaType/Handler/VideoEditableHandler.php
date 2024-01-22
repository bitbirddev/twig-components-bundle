<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use Pimcore\Model\Asset\Video;
use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\YoutubeHelper;

class VideoEditableHandler extends AbstractHandler
{
    public function __construct(protected ?\Pimcore\Model\Document\Editable\Video $editable)
    {
    }

    public static function supports($arg): bool
    {
        return $arg instanceof \Pimcore\Model\Document\Editable\Video;
    }

    public static function make(\Pimcore\Model\Document\Editable\Video $editable): HandlerInterface
    {
        return new self($editable);
    }

    // only when "asset" is selected in the backend you can enter a title
    public function getTitle(): ?string
    {
        return match($this->editable->getVideoType()) {
            "youtube" => null,
            "vimeo" => null,
            "asset" => $this->editable->getTitle(),
            default => null
        };
    }

    // only when "asset" is selected in the backend you can enter a description
    public function getDescription(): ?string
    {
        return match($this->editable->getVideoType()) {
            "youtube" => null,
            "vimeo" => null,
            "asset" => $this->editable->getDescription(),
            default => null
        };
    }


    public function getSources(): array
    {
        /** @var \Pimcore\Model\Document\Editable\Video  $video */
        $video = $this->editable;
        $type = $video->getVideoType();
        $data = $video->getData();

        return  match($type) {
            "youtube" => [["type" => "video/youtube", "src" => YoutubeHelper::createEmbedUrl($data['id'])]],
            "vimeo" => [["type" => "video/vimeo", "src" => VimeoHelper::createEmbedUrl($data['id'])]],
            "asset" => $this->editable->getVideoAsset() instanceof Video ? $this->getAssetVideoThumbnail($this->editable->getVideoAsset()) : [],
            default => []
        };
    }

    public function getPoster(): ?string
    {

        $poster = $this->editable->getPoster();

        return match($this->editable->getVideoType()) {
            "youtube" => null,
            "vimeo" => null,
            "asset" => is_null($poster) ? $poster : $this->editable->getImageThumbnail($this->posterThumbnailName)->getFrontendPath(),
            default => null
        };
    }

    public function getConsents(): array
    {
        return match($this->editable->getVideoType()) {
            "youtube" => ['BJz7qNsdj-7'],
            "vimeo" => ['HyEX5Nidi-m'],
            "asset" => [],
            default => []
        };
    }
}
