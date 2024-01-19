<?php

namespace bitbirddev\TwigComponentsBundle\Twig\Components;

use App\Model\DataObject\Video;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent('media-player', "@TwigComponents/components/media-player.html.twig")]
class MediaPlayerComponent
{
    #[ExposeInTemplate]
    public Video $object;

    #[ExposeInTemplate]
    public function getServices()
    {
        if ($this->object) {
            return $this->object->getNeededConsentServices();
        }
    }

    #[ExposeInTemplate]
    public function getPreviewUrl()
    {
        if ($this->object) {
            return $this->object->getPreviewImage() ? $this->object->getPreviewImage()->getThumbnail('1280_720')->getPath(['deferredAllowed' => false]) : null;
        }
    }

    //
    #[ExposeInTemplate]
    public function getData()
    {
        if ($this->object) {
            return $this->object->toArray();
        }
    }
}
