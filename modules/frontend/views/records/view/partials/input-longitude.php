<?php
/**
 * @var \app\models\Location $location
 */

use yii\widgets\MaskedInput;
?>

<div class="form-group form-group-sm">
    <div class="col-sm-6">
        <?= $location->lng_dms; ?>
    </div>
    <div class="col-sm-6">
        <?= MaskedInput::widget([
            'name' => 'Record[location][lng_ddm]',
            'mask' => '9[9[9]].9[9[9]].9[9[9[9[9]]]]a',
            'value' => $location->lng_ddm,
        ]); ?>
    </div>
</div>