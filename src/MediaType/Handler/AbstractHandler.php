<?php

namespace bitbirddev\TwigComponentsBundle\MediaType\Handler;

use bitbirddev\TwigComponentsBundle\MediaType\HandlerInterface;
use bitbirddev\TwigComponentsBundle\MediaType\MediaInterface;
use Pimcore\Model\Asset\Video;
use Pimcore\Model\Exception\NotFoundException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

abstract class AbstractHandler implements HandlerInterface, MediaInterface
{
    protected $posterThumbnailName =  'twig_components_bundle_1280_720';
    protected $videoThumbnailName =  'twig_components_bundle_720_405';

    public function setPosterThumbnailName(string $posterThumbnail): void
    {
        $this->posterThumbnailName = $posterThumbnail;
    }
    public function setVideoThumbnailName(string $videoThumbnail): void
    {
        $this->videoThumbnailName = $videoThumbnail;
    }

    public function getTitle(): ?string
    {
        return null;
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getCopyright(): ?string
    {
        return null;
    }

    public function getPoster(): ?string
    {
        return null;
    }

    public function getConsents(): array
    {
        return [];
    }

    /**
     * @param Video $asset
     * @return array
     * @throws NotFoundException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    protected function getAssetVideoThumbnail(\Pimcore\Model\Asset\Video $asset): array
    {

        $thumbnail = $asset->getThumbnail($this->videoThumbnailName);

        if (is_array($thumbnail)) {
            if (array_key_exists('status', $thumbnail)) {
                $sources = match($thumbnail['status']) {
                    "finished" => [collect($thumbnail['formats'])->mapWithKeys(function ($src, $format) {
                        return [
                            'src' => $src,
                            'type' => 'video/'.$format,
                            /* 'size' => */
                        ];
                    })->toArray() ],
                    "error" =>  ['status' => 'error'],
                    "inprogress" =>  ['status' => 'inprogress', 'processId' => $thumbnail['processId']],

                };
                return $sources;
            }
        }
    }
}
