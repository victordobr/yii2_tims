<?php
/**
 * @var \app\models\Location $location
 */

?>

<div class="col-sm-6">
    <div class="row">
        <div class="form-group form-group-sm location-dms">
            <?= $location->lng_dms; ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="row">
        <div class="form-group form-group-sm location-dms">
            <?= $location->lng_ddm; ?>
        </div>
    </div>
</div>
