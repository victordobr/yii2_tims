<?php
/**
 * @var $action string
 * @var $model \app\modules\frontend\models\form\DeactivateForm
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'approve-deactivation-form',
    'action' => $action,
    'enableClientValidation' => true,
    'options' => [
        'class' => 'form-horizontal',
        'data-pjax' => true
    ],
    'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
        'template' => "<div class=\"col-lg-8\">{label}\n{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
        'labelOptions' => ['class' => 'control-label'],
    ],
]); ?>

    <div class="col-xs-6">

        <span class="badge" style="font-size: 1.2em;"><?=Yii::t('app', 'STEP 1')?></span>

        <?= $form->field($model, 'requested_by')->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ]); ?>

        <?= $form->field($model, 'review_reason')->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ]); ?>

        <span class="badge" style="font-size: 1.2em;"><?=Yii::t('app', 'STEP 2')?></span>

        <?= $form->field($model, 'action')->radioList($model->actions(), [
            'onclick' => 'js:$("#approve-deactivation-step-3").toggle($(this).find("input[type=radio]:checked").val() == "reject");'
        ])->label(false); ?>

    </div>

    <div id="approve-deactivation-step-3" class="col-xs-6" style="display: none">

        <span class="badge" style="font-size: 1.2em;"><?=Yii::t('app', 'STEP 3')?></span>

        <?= $form->field($model, 'code')->dropDownList([10 => 10]); ?>

        <?= $form->field($model, 'description')->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ]) ?>

    </div>

    <div class="form-group">
        <div class="pull-right">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>