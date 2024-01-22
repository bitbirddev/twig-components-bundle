<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use Pimcore\Model\Asset\Video;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\YoutubeHelper;

class DataObjectHandler extends AbstractHandler
{
    public function __construct(protected ?\Pimcore\Model\DataObject $object)
    {
    }

    public static function supports($arg): bool
    {
        return $arg instanceof \Pimcore\Model\DataObject && $arg->getVideo() instanceof \Pimcore\Model\DataObject\Data\Video;
    }

    public static function make(\Pimcore\Model\DataObject $object): HandlerInterface
    {
        return new self($object);
    }

    public function getPoster(): ?string
    {
        $image = $this->object->getPreviewImage();
        if($image instanceof \Pimcore\Model\DataObject\Data\Hotspotimage) {
            return $image->getThumbnail($this->posterThumbnailName)->getFrontendPath();

        } elseif($image instanceof \Pimcore\Model\Asset\Image) {
            return $image->getThumbnail($this->posterThumbnailName)->getFrontendPath();
        }
    }

    public function getSources(): array
    {
        /** @var \Pimcore\Model\DataObject\Data\Video $video */
        $video = $this->object->getVideo();
        $type = $video->getType();
        $data = $video->getData();

        return  match($video->getType()) {
            "youtube" => [["type" => "video/youtube", "src" => YoutubeHelper::createEmbedUrl($data)]],
            "vimeo" => [["type" => "video/vimeo", "src" => VimeoHelper::createEmbedUrl($data)]],
            "asset" => $this->getAssetVideoThumbnail($data),
            default => []
        };
    }

    public function getCopyright(): ?string
    {
        return $this->object->getCopyright();
    }


    public function getConsents(): array
    {
        return match($this->object->getVideo()->getType()) {
            "youtube" => ['BJz7qNsdj-7'],
            "vimeo" => ['HyEX5Nidi-m'],
            "asset" => [],
            default => []
        };

    }

    public function getTitle(): ?string
    {
        return $this->object->getTitle();
    }


}
