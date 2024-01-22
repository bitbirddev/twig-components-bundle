<?php

use bitbirddev\TwigComponentsBundle\MediaType\Handler\AssetVideoHandler;

$video = new \Pimcore\Model\Asset\Video();


test('AssetVideoHandler', function ($video) {
    expect(AssetVideoHandler::supports($video))->toBeTrue();
})->with([ $video ]);
