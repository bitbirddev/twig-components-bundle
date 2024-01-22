<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Helper;

class YoutubeHelper
{
    public const REGEX = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';

    public static function isValidUrl(string $url): bool
    {
        return preg_match(self::REGEX, $url);
    }

    /**
    * Return the id of a youtube url if url is valid, otherwise false
     * @param string $url
     * @return bool|string
     */
    public static function matchUrl(string $url): bool|string
    {
        if (preg_match(self::REGEX, $url, $matches)) {
            return $matches[6];
        }
        return false;
    }

    public static function createEmbedUrl(string $id): string
    {
        return "https://www.youtube-nocookie.com/embed/{$id}";
    }
}
