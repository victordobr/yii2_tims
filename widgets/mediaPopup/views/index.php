<?php

namespace app\widgets\mediaPopup;

use app\enums\FileType;

/**
 * @var $url
 * @var $type
 * @var $modalId
 */
?>

<a id="<?php if ( $type == FileType::TYPE_VIDEO){print "video";} ?>" class="img-pic" data-toggle="modal" data-target="#<?= $modalId?>" id="modalButton" ><!--<img src="/images/photo-icon.png"/>--></a>

<div class="modal" id="<?= $modalId?>" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times</button>
                <h4 class="modal-title"> Photo / Video Evidence</h4>
            </div>
            <div class="modal-body">
                <p>
                <?php if ($type == FileType::TYPE_IMAGE ): ?>
                <p>
                <img width="500px" height="500px" src="<?= $url; ?>"/>
                </p>
                <?php elseif ( $type == FileType::TYPE_VIDEO): ?>
                <p>
                    <video width="400" controls>
                        <source src="<?= $url ?>" type="video/mp4">
                    </video>
                    </p>
                <? endif; ?>
                </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>


