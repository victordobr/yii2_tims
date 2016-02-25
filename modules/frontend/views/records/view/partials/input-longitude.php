<?php
/**
 * @var \app\models\Location $location
 * @var \yii\widgets\ActiveForm $form
 */

use yii\widgets\MaskedInput;

?>

<div class="form-group form-group-sm">
    <div class="col-sm-6">
        <?= $location->lng_dms; ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($location, 'lng_ddm', [
            'options' => ['class' => 'form-group form-group-sm'],
        ])->widget(MaskedInput::classname(), [
            'mask' => '9[9[9]].9[9[9]].9[9[9[9[9]]]]a',
        ])->label(false) ?>
    </div>
</div>