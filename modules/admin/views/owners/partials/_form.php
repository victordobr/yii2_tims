<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\enums\States;
use app\enums\VehicleColors;
use app\models\Vehicle;

/* @var $this yii\web\View */
/* @var $model app\models\Owner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address_2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state_id')->dropDownList(
        States::listData()
    ) ?>

    <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle_id')->dropDownList(
        Vehicle::getVehicleList()
    ) ?>

    <?= $form->field($model, 'vehicle_year')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'vehicle_color_id')->dropDownList(
        VehicleColors::listData()
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
