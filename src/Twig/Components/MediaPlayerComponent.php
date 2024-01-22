<?php

namespace bitbirddev\TwigComponentsBundle\Twig\Components;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use bitbirddev\TwigComponentsBundle\MediaType\Handler\AbstractHandler;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('media-player', "@TwigComponents/components/media-player.html.twig")]
class MediaPlayerComponent
{
    public AbstractHandler $video;

    public string $title;
    public string $description;
    public string $copyright;

    public ?string $posterThumbnail = null;
    public ?string $videoThumbnail = null;

    public ?array $sources;
    public ?string $poster;
    public ?array $consents;

    public function __construct(
        protected HandlerCollection $matcher
    ) {
    }

    public function mount($video): void
    {
        $wrapper = $this->matcher->match($video);
        if($wrapper instanceof AbstractHandler) {
            $this->video = $wrapper;
        }
    }

    #[PostMount()]
    public function preMount(): void
    {
        if($this->videoThumbnail) {
            $this->video->setVideoThumbnailName($this->videoThumbnail);
        }
        if($this->posterThumbnail) {
            $this->video->setPosterThumbnailName($this->posterThumbnail);
        }
    }

    #[ExposeInTemplate('title')]
    public function getTitle(): ?string
    {
        return $this->title ?? $this->video->getTitle();
    }

    #[ExposeInTemplate('description')]
    public function getDescription(): ?string
    {
        return $this->description ?? $this->video->getDescription();
    }

    #[ExposeInTemplate('copyright')]
    public function getCopyright(): ?string
    {
        return $this->copyright ?? $this->video->getCopyright();
    }

    #[ExposeInTemplate('sources')]
    public function getSources(): array
    {
        return $this->sources ?? $this->video->getSources();
    }

    #[ExposeInTemplate('poster')]
    public function getPoster(): ?string
    {
        return $this->poster ?? $this->video->getPoster();
    }

    #[ExposeInTemplate('consents')]
    public function getConsents(): array
    {
        return $this->consents ?? $this->video->getConsents();
    }


}
