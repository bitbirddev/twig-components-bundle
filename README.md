# Twig Videoplayer-Component with optional Usercentrics PrivacyWall (to be used with Pimcore)

## What is this?

This Package provides a MediaPlayer Twig Component especially designed to be used with Pimcore CMS.

Use this component and throw something at it. It will handle the most common video types like Youtube, Vimeo and Facebook.

```twig
Pimcore VideoEditable
<twig:media-player :video="pimcore_video('video')">

Pimcore VideoDataType
<twig:media-player :video="dataObject.video">

Pimcore Asset
<twig:media-player :video="pimcore_asset(videoAssetId)">

Pimcore Asset ID
<twig:media-player :video="23">

Facebook Video
<twig:media-player video="https://www.facebook.com/aguardos.nocturnos/videos/vb.1614866072064590/1828228624061666/?type=2&theater">

Youtube URL
<twig:media-player video="http://www.youtube.com/watch?v=DFYRQ_zQ-gk">

Vimeo URL
<twig:media-player video="http://vimeo.com/123456789">

Source Array
<twig:media-player :video="['https://test.de/yourvideo.mp4]">

Your Custom DataObject (see below for VideoHandler Example)
<twig:media-player :video="pimcore_object(customObjectId)">
```

## Depends on

[@bitbirddev/web-components](https://github.com/bitbirddev/web-components/tree/main)

[vidstack/player](https://github.com/vidstack/player)

## Installation

`composer require bitbirddev/twig-components-bundle`

## Sample Usage

```twig
<twig:media-player video="http://www.youtube.com/watch?v=DFYRQ_zQ-gk" class="rounded mb-6" />
```

## Usage without Consent-Wall

Option 1: return an empty array in the getConsents() method of your custom handler

Option 2: set the `consents` attribute to an empty array in the component

```
<twig:media-player :consents="[]" video="http://www.youtube.com/watch?v=DFYRQ_zQ-gk" class="rounded mb-6" />
```

## VideoHandler Example

```php
<?php

namespace App\Media\Handler\DataObject;

use bitbirddev\TwigComponentsBundle\MediaType\Handler\AbstractHandler;
use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\FacebookHelper;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\YoutubeHelper;

class Video extends AbstractHandler
{
    public function __construct(protected ?\Pimcore\Model\DataObject\Video $object)
    {
    }

    public static function supports($arg): bool
    {
        return $arg instanceof \Pimcore\Model\DataObject\Video && ($arg->getVideo() instanceof \Pimcore\Model\DataObject\Data\Video || $arg->getFbVideoId());
    }

    public static function make(\Pimcore\Model\DataObject\Video $object): HandlerInterface
    {
        return new self($object);
    }

    public function getPoster(): ?string
    {
        if (method_exists($this->object, 'getPreviewImage')) {
            $image = $this->object->getPreviewImage();
            if ($image instanceof \Pimcore\Model\DataObject\Data\Hotspotimage) {
                return $image->getThumbnail($this->posterThumbnailName)->getFrontendPath();
            } elseif ($image instanceof \Pimcore\Model\Asset\Image) {
                return $image->getThumbnail($this->posterThumbnailName)->getFrontendPath();
            }
        }

        return null;
    }

    public function getSources(): array
    {
        // Facebook video
        if ($this->object->getFbVideoId()) {
            return [['type' => 'video/facebook', 'src' => FacebookHelper::createEmbedUrl($this->object->getFbVideoId())]];
        }

        /** @var \Pimcore\Model\DataObject\Data\Video $video */
        $video = $this->object->getVideo();
        $type = $video->getType();
        $data = $video->getData();

        return match ($video->getType()) {
            'youtube' => [['type' => 'video/youtube', 'src' => YoutubeHelper::createEmbedUrl($data)]],
            'vimeo' => [['type' => 'video/vimeo', 'src' => VimeoHelper::createEmbedUrl($data)]],
            'asset' => $this->getAssetVideoThumbnail($data),
            default => [],
        };
    }

    public function getCopyright(): ?string
    {
        return $this->object->getCopyright();
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getConsents(): array
    {
        // Facebook video
        if ($this->object->getFbVideoId()) {
            return ['r5-Z_erQ0'];
        }

        return match ($this->object->getVideo()->getType()) {
            'youtube' => ['BJz7qNsdj-7'],
            'vimeo' => ['HyEX5Nidi-m'],
            'asset' => [],
            default => [],
        };
    }

    public function getTitle(): ?string
    {
        return $this->object->getTitle();
    }

    public function getAspectRatio(): string
    {
        return $this->object->getAspectRatio() ?? '16:9';
    }
}

```
