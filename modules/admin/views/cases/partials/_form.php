<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PoliceCase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="police-case-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'open_date')->textInput() ?>

    <?= $form->field($model, 'officer_date')->textInput() ?>

    <?= $form->field($model, 'mailed_date')->textInput() ?>

    <?= $form->field($model, 'officer_pin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'officer_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
