<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\search\Case */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="police-case-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'open_date') ?>

    <?php // echo $form->field($model, 'officer_date') ?>

    <?php // echo $form->field($model, 'mailed_date') ?>

    <?php // echo $form->field($model, 'officer_pin') ?>

    <?php // echo $form->field($model, 'officer_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
