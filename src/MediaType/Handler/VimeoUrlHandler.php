<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;

class VimeoUrlHandler extends AbstractHandler
{
    public function __construct(protected ?string $vimeoId = null, protected ?string $hash = null)
    {
    }

    public static function supports($arg): bool
    {
        if(!is_string($arg)) {
            return false;
        }

        return VimeoHelper::isValidUrl($arg);
    }

    public static function make(string $url): HandlerInterface
    {
        if($matches = VimeoHelper::matchUrl($url)) {
            return new self($matches['id'], $matches['hash']);
        }
    }
    public function getId(): string
    {
        return $this->vimeoId;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getSources(): array
    {
        return [["src" => VimeoHelper::createEmbedUrl($this->getId(), $this->getHash()), "type" => "video/vimeo"]];
    }

    public function getConsents(): array
    {

        return ['HyEX5Nidi-m'];
    }
}
