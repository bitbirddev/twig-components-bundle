<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Helper;

class VimeoHelper
{
    public const REGEX = '/^(?:http|https)?:?\/?\/?(?:www\.)?(?:player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|video\/|)(?<id>\d+)(?:|\/\?)(?:.*h(?:ash)?=(?<hash>[0-9a-z]+).*)?/';

    public static function isValidUrl(string $url): bool
    {
        return preg_match(self::REGEX, $url);
    }

    /**
    * Return the id of a vimeo url if url is valid, otherwise false
     * @param string $url
     * @return bool|string
     */
    public static function matchUrl(string $url): array|bool
    {
        if (preg_match(self::REGEX, $url, $matches)) {
            return [
              'id' => $matches['id'] ?? null,
              'hash' => $matches['hash'] ?? null,
            ];
        }
        return false;
    }

    public static function createEmbedUrl(string $id, ?string $hash = null): string
    {

        // if we got no hash, we check if source is from a pimcore editable where only the id of the video is stored
        // like "823355845/bf09c2707b" or "823355845?hash=bf09c2707b" or "823355845?h=bf09c2707b" and try to get an hash from it

        if(!$hash) {
            if(preg_match('/^(?<id>\d+)(?:[\/|\?|\&])h?(?:ash)?=?(?<hash>[0-9a-zA-Z]+)/', $id, $matches)) {
                $id = $matches['id'];
                $hash = $matches['hash'];
            }
        }
        return "https://player.vimeo.com/video/{$id}".($hash ? "?hash=".$hash : null) ;
    }

}
