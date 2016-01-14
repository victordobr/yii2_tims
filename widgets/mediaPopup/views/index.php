<?php

namespace app\widgets\mediaPopup;

use app\enums\FileType;
use branchonline\lightbox\Lightbox;
use \kato\VideojsWidget;

/**
 * @var $url
 * @var $type
 * @var $modalId
 * @var $icon
 * @var $title
 * @var $mime
 */
?>
<div class="media-popup-wrapper">
    <a id="modalButton" class="img-pic" data-toggle="modal" data-target="#<?= $modalId ?>"
       title="<?= $title; ?>"><?= $icon; ?></a>

    <div class="modal" id="<?= $modalId ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times</button>
                    <h4 class="modal-title">Evidence - <?= $title; ?></h4>
                </div>
                <div class="modal-body">
                    <?php if ($type == FileType::TYPE_IMAGE): ?>
                        <p>
                            <a target="_blank" class="media-link" href="<?= $url?>">Download / View</a>
                        </p>
                        <span class="lightbox-thumb">
                            <?= Lightbox::widget([
                                'files' => [
                                    [
                                        'thumb' => $url,
                                        'original' => $url,
                                        'title' => $title,
                                    ],
                                ]
                            ]); ?>
                        </span>
                    <?php elseif ($type == FileType::TYPE_VIDEO): ?>
                        <p>
                            <a target="_blank" class="media-link" href="<?= $url?>">Download / View</a>
                        </p>
                        <span>
                            <?= VideojsWidget::widget([
                                'options' => [
                                    'class' => 'video-js vjs-default-skin vjs-big-play-centered',
//                                    'poster' => $this->getThumbUrl($item),
                                    'controls' => true,
                                    'preload' => 'auto',
                                    'width' => '100%',
                                    'height' => '300',
                                    'data-setup' => '{ "plugins" : { "resolutionSelector" : { "default_res" : "720" } } }',
                                ],
                                'tags' => [
                                    'source' => [
                                        [
                                            'src' => $url,
//                                            'type' => 'video/x-msvideo',
                                            'type' => $mime,
//                                            'data-res' => '720',
                                        ],
                                    ],
                                ],
                                'multipleResolutions' => true,
                            ]); ?>
                        </span>
                    <?php endif; ?>
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>