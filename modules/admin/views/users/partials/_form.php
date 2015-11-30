<?php

use \yii\helpers\Html;
//use \yii\bootstrap\ActiveForm;
use \yii\bootstrap\ActiveForm;
use \kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <div class="form-group">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'required-asterisk'],
        ]); ?>
        <?= $form->field($model, 'is_active')->textInput()->widget(CheckboxX::classname(), [
            'class'         => 'form-control form-field-short',
            'pluginOptions' => ['threeState' => false]
        ]); ?>

        <?= $form->field($model, 'type_id')->dropDownList(app\enums\UserType::listData(), [
            'prompt' => '',
            'class'  => 'form-control form-field-short',
        ]) ?>

        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'class'  => 'form-control form-field-short',
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
            'class'  => 'form-control form-field-short',
        ]) ?>

        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'class'  => 'form-control form-field-short',
        ]) ?>

        <?= $form->field($model, 'phone')->textInput([
            'maxlength' => true,
            'class'  => 'form-control form-field-short',
        ]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Save'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a( \Yii::t('app', 'Users'), ['manage'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
