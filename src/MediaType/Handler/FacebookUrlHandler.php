<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\FacebookHelper;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;

class FacebookUrlHandler extends AbstractHandler
{
    public function __construct(protected ?string $fbId = null)
    {
    }

    public static function supports($arg): bool
    {
        if(!is_string($arg)) {
            return false;
        }

        return FacebookHelper::isValidUrl($arg);

    }

    public static function make(string $url): HandlerInterface
    {
        if($id = FacebookHelper::matchUrl($url)) {
            return new self($id);
        }
    }

    public function getId(): string
    {
        return $this->fbId;
    }


    public function getSources(): array
    {
        return [["src" => FacebookHelper::createEmbedUrl($this->getId()), "type" => "video/facebook"]];
    }

    public function getConsents(): array
    {

        return ['r5-Z_erQ0'];
    }
}
