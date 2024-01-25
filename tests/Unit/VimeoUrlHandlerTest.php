<?php

use bitbirddev\TwigComponentsBundle\MediaType\Handler\VimeoUrlHandler;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\VimeoHelper;

$goodUrls = [
    ["url" => "vimeo.com/123456789", "id" => "123456789"],
    ["url" => "vimeo.com/123456789", "id" => "123456789"],
    ["url" => "vimeo.com/channels/mychannel/123456789", "id" => "123456789"],
    ["url" => "vimeo.com/groups/shortfilms/videos/123456789", "id" => "123456789"],
    ["url" => "player.vimeo.com/video/123456789", "id" => "123456789"],
    ["url" => "http://vimeo.com/123456789", "id" => "123456789"],
    ["url" => "https://vimeo.com/channels/mychannel/123456789", "id" => "123456789"],
    ["url" => "https://vimeo.com/groups/shortfilms/videos/123456789", "id" => "123456789"],
    ["url" => "https://www.player.vimeo.com/video/123456789", "id" => "123456789"],
    ["url" => "http://vimeo.com/channels/staffpicks/48237094", "id" => "48237094"],
    ["url" => "http://vimeo.com/48237094", "id" => "48237094"],
    ["url" => "https://www.vimeo.com/19706846", "id" => "19706846"],
    ["url" => "https://vimeo.com/19706846", "id" => "19706846"],
    ["url" => "https://player.vimeo.com/video/19706846&jjk", "id" => "19706846"],
    ["url" => "https://vimeo.com/341842996?app_id=122963", "id" => "341842996"],
];

$badUrls = [
    ["url" => "sdiavimero.com/123456789", "id" => null],
    ["url" => "vimero.com/123456789", "id" => null],
    ["url" => "vimeo.de/12346789asdf/asdf", "id" => null],
    ["url" => "vimeo.com/chanels/mychannel/123/123456789", "id" => null],
    ["url" => "vimeo.com/groups//shortfilms/videos/123456789", "id" => null],
    ["url" => " vimeo.com/groups//shortfilms/videos/123456789", "id" => null],
];

test('Good VimeoUrls', function ($url) {
    expect(VimeoHelper::isValidUrl($url))->toBeTrue();
})->with($goodUrls);

test('Bad VimeoUrls', function ($url) {
    expect(VimeoHelper::isValidUrl($url))->toBeFalse();
})->with($badUrls);

test('Vimeo ID Matcher', function ($url, $id) {
    expect(VimeoHelper::matchUrl($url))->toBe(["id" => $id, "hash" => null]);
})->with($goodUrls);

test('VimeoSources', function ($url, $id) {
    expect(VimeoUrlHandler::make($url)->getSources())->toBe([["src" => VimeoHelper::createEmbedUrl($id), "type" => "video/vimeo"]]);
})->with($goodUrls);
