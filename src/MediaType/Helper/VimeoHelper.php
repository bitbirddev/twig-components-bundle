<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Helper;

class VimeoHelper
{
    public const REGEX = '/^(?:http|https)?:?\/?\/?(?:www\.)?(?:player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|video\/|)(\d+)(?:|\/\?)/';

    public static function isValidUrl(string $url): bool
    {
        return preg_match(self::REGEX, $url);
    }

    /**
    * Return the id of a vimeo url if url is valid, otherwise false
     * @param string $url
     * @return bool|string
     */
    public static function matchUrl(string $url): bool|string
    {
        if (preg_match(self::REGEX, $url, $matches)) {
            return $matches[1];
        }
        return false;
    }

    public static function createEmbedUrl(string $id): string
    {
        return "https://player.vimeo.com/video/{$id}";
    }

}
