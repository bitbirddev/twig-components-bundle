<?php

use bitbirddev\TwigComponentsBundle\MediaType\Handler\YoutubeUrlHandler;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\YoutubeHelper;

$goodUrls = [
    ["url" => "https://www.youtube.com/watch?v=DFYRQ_zQ-gk&feature=featured", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://www.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//www.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "www.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://m.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://m.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//m.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "m.youtube.com/watch?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US", "id" => "DFYRQ_zQ-gk"],
    ["url" => "www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US", "id" => "DFYRQ_zQ-gk"],
    ["url" => "youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube.com/embed/DFYRQ_zQ-gk?autoplay=1", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://www.youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//www.youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "www.youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//youtube.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube-nocookie.com/embed/DFYRQ_zQ-gk?autoplay=1", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://www.youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//www.youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "www.youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "youtube-nocookie.com/embed/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://youtu.be/DFYRQ_zQ-gk?t=120", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://youtu.be/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "http://youtu.be/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "//youtu.be/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "youtu.be/DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
    ["url" => "https://www.youtube.com/HamdiKickProduction?v=DFYRQ_zQ-gk", "id" => "DFYRQ_zQ-gk"],
];

$badUrls = [
    ["url" => "https://www.youutube.com/HamdiKickProduction?v=DFYRQ_zQ-gk", "id" => null],
];

test('Good YoutubeUrls', function ($url) {
    expect(YoutubeHelper::isValidUrl($url))->toBeTrue();
})->with($goodUrls);

test('Bad YoutubeUrls', function ($url) {
    expect(YoutubeHelper::isValidUrl($url))->toBeFalse();
})->with($badUrls);

test('YoutubeMatcher::make()', function ($url, $id) {
    expect(YoutubeHelper::matchUrl($url))->toBe($id);
})->with($goodUrls);

test('YoutubeSources', function ($url, $id) {
    expect(YoutubeUrlHandler::make($url)->getSources())->toBe([["src" => YoutubeHelper::createEmbedUrl($id), "type" => "video/youtube"]]);
})->with($goodUrls);
