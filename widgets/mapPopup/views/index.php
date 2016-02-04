<?php

namespace app\widgets\mapPopup;
/**
 * @var $latitude;
 * @var $longitude;
 * @var $modalId;
 * @var $icon;
 * @var string $text;
 */

?>
<div class="media-popup-wrapper">
    <a id="modal-button-<?= $modalId ?>" class="img-pic" data-toggle="modal" data-target="#<?= $modalId ?>"
       title=""><?= $icon; ?><?= $text; ?></a>
    <div class="modal" id="<?= $modalId ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times</button>
                    <h4 class="modal-title">Location</h4>
                </div>
                <div class="modal-body">
                    <div id="googleMap" style="width:100%;height:380px;"></div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>