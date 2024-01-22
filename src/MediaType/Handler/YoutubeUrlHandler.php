<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\Helper\YoutubeHelper;
use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;

class YoutubeUrlHandler extends AbstractHandler
{
    public function __construct(protected ?string $youtubeId = null)
    {
    }


    public static function supports($arg): bool
    {
        if(!is_string($arg)) {
            return false;
        }

        return YoutubeHelper::isValidUrl($arg);

    }

    public static function make(string $url): HandlerInterface
    {
        if($id = YoutubeHelper::matchUrl($url)) {
            return new self($id);
        }
    }

    public function getId(): string
    {
        return $this->youtubeId;
    }

    public function getSources(): array
    {
        return [["src" => YoutubeHelper::createEmbedUrl($this->getId()), "type" => "video/youtube"]];
    }

    public function getConsents(): array
    {
        return ['BJz7qNsdj-7'];
    }

}
