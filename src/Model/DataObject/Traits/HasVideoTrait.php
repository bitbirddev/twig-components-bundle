<?php

namespace bitbirddev\TwigComponentsBundle\Model\DataObject\Traits;

/**
 * @method \Pimcore\Model\DataObject\Data\Video getVideo()
 */
trait HasVideoTrait
{
    public function toArray()
    {
        $type = $this->getVideo()->getType();

        return [
            'type' => $type == 'asset' ? 'video' : $type, // wenn asset dann type = 'video'
            'title' => $this->getTitle() ? $this->getTitle() : '',
            'sources' => [$this->getSources()],
            'poster' => $this->getPreviewImage() ? $this->getPreviewImage()->getThumbnail('1280_720')->getPath(['deferredAllowed' => false]) : null,
            'tracks' => [],
            'copyright' => $this->getCopyright(),
            'previewThumbnails' => [],

        ];
    }

    public function getSrc(string $type, string $id): ?string
    {
        if ($type == 'youtube') {
            if (str_starts_with($id, 'https://')) {
                return $id;
            } else {
                return 'https://www.youtube-nocookie.com/embed/'.$id;
            }
        } elseif ($type == 'vimeo') {
            if (str_starts_with($id, 'https://')) {
                return $id;
            } else {
                return 'https://player.vimeo.com/video/'.$id;
            }
        }
    }

    public function getSources()
    {
        $type = $this->getVideo()->getType();

        // youtube, vimeo, dailymotion
        if ($type == 'youtube' || $type == 'vimeo') {
            return [
                'src' => $this->getSrc($type, $this->getVideo()->getData()),
                'type' => "video/{$this->getVideo()->getType()}",
            ];
        }

        // asset
        if ($type == 'asset') {
            if ($this->getVideo()->getData() instanceof \Pimcore\Model\Asset\Video) {
                $thumbnail = $this->getVideo()->getData()->getThumbnail('720_405');

                if (is_array($thumbnail)) {
                    if (array_key_exists('status', $thumbnail)) {
                        $status = $thumbnail['status'];
                        if ($status == 'finished') {
                            if (array_key_exists('formats', $thumbnail)) {
                                return collect($thumbnail['formats'])->mapWithKeys(function ($src, $key) {
                                    return [
                                        'src' => $src,
                                        'type' => 'video/'.$key,
                                        /* 'size' => */
                                    ];
                                })->toArray();
                            }
                        } elseif ($status == 'inprogress') {
                            $progressId = $thumbnail['processId'];

                            return ['status' => 'inprogress', 'processId' => $progressId];
                        }
                    }
                } else {
                    // transcoding error
                    return ['status' => 'error'];
                }
            }
        }
    }

    public function getNeededConsentServices()
    {
        $type = $this->getVideo()->getType();
        if ($type == 'youtube') {
            return ['BJz7qNsdj-7'];
        } elseif ($type == 'vimeo') {
            return ['HyEX5Nidi-m'];
        } elseif ($type == 'dailymotion') {
            return ['VJNO26pZe'];
        } elseif ($type == 'asset') {
            return [];
        }
    }
}
