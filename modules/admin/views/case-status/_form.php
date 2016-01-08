<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CaseStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="case-status-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'StatusName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'StatusDescription')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
