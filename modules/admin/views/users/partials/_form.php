<?php

use \yii\helpers\Html;
//use \yii\bootstrap\ActiveForm;
use \yii\bootstrap\ActiveForm;
use \kartik\checkbox\CheckboxX;
use app\models\Question;

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

        <?= $form->field($model, 'pre_name')->dropDownList(
            \app\models\User::getPreNameList()
        ); ?>

        <?= $form->field($model, 'address')->textInput([
            'maxlength' => true,
            'class'  => 'form-control form-field-short',
        ]) ?>

        <?= $form->field($model, 'zip_code')->textInput([
            'maxlength' => true,
            'class'  => 'form-control form-field-short',
        ]) ?>


        <?= $form->field($model, 'state_id')->dropDownList(
            \app\enums\States::listData()
        ); ?>

        <?= $form->field($model, 'question_id')->dropDownList(
            Question::find()->select(['text', 'id'])->indexBy('id')->column(),
            array('prompt' => ' - choose question - ')
          ); ?>


        <?= $form->field($model, 'question_answer')->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Save'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a( \Yii::t('app', '<< All Users'), ['manage'], ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
