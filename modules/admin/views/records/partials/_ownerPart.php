<?php

use app\enums\States;
use app\enums\VehicleColors;
use app\models\Vehicle;

/* @var $this yii\web\View */
/* @var $owner app\models\Owner */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($owner, 'first_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'middle_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'vehicle_id')->dropDownList(
    Vehicle::getVehicleList()
) ?>

<?= $form->field($owner, 'vehicle_year')->textInput(['maxlength' => 4]) ?>

<?= $form->field($owner, 'vehicle_color_id')->dropDownList(
    VehicleColors::listData()
) ?>

<?= $form->field($owner, 'address_1')->textarea(['rows' => 1]) ?>

<?= $form->field($owner, 'city')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'state_id')->dropDownList(
    States::listData()
) ?>

<?= $form->field($owner, 'zip_code')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'license')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($owner, 'phone')->textInput(['maxlength' => true]) ?>