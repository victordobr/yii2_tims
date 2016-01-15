<?php
/**
 * @var $model \app\modules\frontend\models\form\DeactivateForm
 * @var $action string
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>
    <h3><?= Yii::t('app', 'Request deactivation'); ?></h3>

<?php $form = ActiveForm::begin([
    'id' => 'deactivate-form',
    'action' => $action,
    'enableClientValidation' => true,
    'options' => [
        'class' => 'form-horizontal',
        'data-pjax' => true
    ],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],
]); ?>

<?= $form->field($model, 'code')->dropDownList([10 => 10]); ?>

<?= $form->field($model, 'description')->textInput([
    'maxlength' => true,
    'class' => 'form-control form-field-short',
]) ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-8">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>