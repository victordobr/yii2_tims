<?php
/**
 * @var \app\models\Location $location
 * @var \yii\widgets\ActiveForm $form
 */

use yii\widgets\MaskedInput;

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
        <?= $form->field($location, 'lng_ddm', [
            'options' => ['class' => 'form-group form-group-sm'],
        ])->widget(MaskedInput::classname(), [
            'mask' => '9[9[9]].9[9[9]].9[9[9[9[9]]]]a',
            'class' => '',
        ])->label(false) ?>
    </div>
</div>