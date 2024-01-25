<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Helper;

class FacebookHelper
{
    public const REGEX = '@^(?:https?://(?:[\w-]+\.)?(?:facebook\.com|facebookwkhpilnemxj7asaniu7vnjjbiltxjqhye3mhbshg7kx5tfyd\.onion)/(?:[^#]*?\#!/)?(?:(?:video/video\.php|photo\.php|video\.php|video/embed|story\.php|watch(?:/live)?/?)\?(?:.*?)(?:v|video_id|story_fbid)=|[^/]+/videos/(?:[^/]+/)?|[^/]+/posts/|groups/[^/]+/permalink/|watchparty/)|facebook:)(\d+)@';

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
            return $matches[1];
        }
        return false;
    }

    public static function createEmbedUrl(string $id): string
    {
        return "https://www.facebook.com/video.php?v={$id}";
    }

}
