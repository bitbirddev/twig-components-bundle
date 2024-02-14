<?php

namespace bitbirddev\TwigComponentsBundle\Twig\Components;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use bitbirddev\TwigComponentsBundle\MediaType\Handler\AbstractHandler;
use Symfony\UX\TwigComponent\Attribute\PostMount;

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
    public ?string $aspectRatio = null;

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

    #[ExposeInTemplate('fbVideoWidth')]
    public function getFbVideoWidth(): int
    {
        if($this->getAspectRatio()) {
            if(preg_match('@^(\d+)/(\d+)$@', $this->aspectRatio, $matches)) {
                return intval($matches[1]) * 1000;
            }
        }
        return 1280;
    }
    #[ExposeInTemplate('fbVideoHeight')]
    public function getFbVideoHeight(): int
    {
        if($this->getAspectRatio()) {
            if(preg_match('@^(\d+)/(\d+)$@', $this->aspectRatio, $matches)) {
                return intval($matches[2]) * 1000;
            }
        }
        return 720;
    }

    #[ExposeInTemplate('aspectRatio')]
    public function getAspectRatio(): string
    {
        return $this->aspectRatio ?? $this->video->getAspectRatio();

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
