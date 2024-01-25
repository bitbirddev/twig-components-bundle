<?php

use bitbirddev\TwigComponentsBundle\MediaType\Handler\FacebookUrlHandler;
use bitbirddev\TwigComponentsBundle\MediaType\Helper\FacebookHelper;

$goodUrls = [
    ["url" => "https://www.facebook.com/aguardos.nocturnos/videos/vb.1614866072064590/1828228624061666/?type=2&theater", "id" => "1828228624061666"],
];

$badUrls = [
    ["url" => "https://www.youutube.com/HamdiKickProduction?v=DFYRQ_zQ-gk", "id" => null],
];

test('Good FacebookUrls', function ($url) {
    expect(FacebookHelper::isValidUrl($url))->toBeTrue();
})->with($goodUrls);

test('Bad FacebookUrls', function ($url) {
    expect(FacebookHelper::isValidUrl($url))->toBeFalse();
})->with($badUrls);

test('FacebookMatcher::make()', function ($url, $id) {
    expect(FacebookHelper::matchUrl($url))->toBe($id);
})->with($goodUrls);

test('FacebookSources', function ($url, $id) {
    expect(FacebookUrlHandler::make($url)->getSources())->toBe([["src" => FacebookHelper::createEmbedUrl($id), "type" => "video/facebook"]]);
})->with($goodUrls);
