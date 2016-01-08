<?php

namespace app\widgets\mediaPopup;

use app\enums\FileType;
use branchonline\lightbox\Lightbox;
/**
 * @var $url
 * @var $type
 * @var $modalId
 * @var $icon
 * @var $title
 */
?>
<div class="media-popup-wrapper">
    <a id="modalButton" class="img-pic" data-toggle="modal" data-target="#<?= $modalId ?>" title="<?= $title; ?>"><?= $icon; ?></a>
    <div class="modal" id="<?= $modalId ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times</button>
                    <h4 class="modal-title">Evidence - <?= $title; ?></h4>
                </div>
                <div class="modal-body">
                    <?php if ($type == FileType::TYPE_IMAGE): ?>
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
                        <span>
                            <video width="500" controls>
                                <source src="<?= $url ?>" type="video/mp4">
                            </video>
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