<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Evidence */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evidence-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'case_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'video_lpr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'video_overview_camera')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_lpr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_overview_camera')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
