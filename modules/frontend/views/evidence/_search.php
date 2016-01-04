<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\frontend\models\search\Evidence */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evidence-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'case_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'video_lpr') ?>

    <?= $form->field($model, 'video_overview_camera') ?>

    <?php // echo $form->field($model, 'image_lpr') ?>

    <?php // echo $form->field($model, 'image_overview_camera') ?>

    <?php // echo $form->field($model, 'license') ?>

    <?php // echo $form->field($model, 'state_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
