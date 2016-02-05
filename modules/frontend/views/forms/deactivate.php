<?php
/**
 * @var $action string
 * @var $reasonsList array
 * @var $model \app\modules\frontend\models\form\DeactivateForm
 */

use yii\helpers\Html;
use app\widgets\base\ActiveForm;

?>

<div class="col-lg-12">
    <?php $form = ActiveForm::begin([
        'title' => Yii::t('app', 'Request deactivation'),
        'id' => 'deactivate-form',
        'action' => $action,
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'options' => [
            'class' => 'form-horizontal',
            'data-pjax' => true
        ],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-12\">{label}\n{input}</div>\n<div class=\"col-lg-11 \">{error}</div>",
        ],
    ]); ?>

    <div class="col-lg-6">

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 1') ?></span>
        </legend>

        <?= $form->field($model, 'requested_by')->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
            'disabled' => 'disabled'
        ])->label(Yii::t('app', 'Deactivation requested by')); ?>

        <?= $form->field($model, 'review_reason')->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
            'disabled' => 'disabled'
        ])->label(Yii::t('app', 'Review reason for deactivation request')); ?>

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 2') ?></span>
        </legend>

        <?= $form->field($model, 'action')->radioList($model->actions(), [
            'onclick' => 'js:$("#approve-deactivation-step-3").toggle($(this).find("input[type=radio]:checked").val() == "reject");'
        ])->label(false); ?>

    </div>

    <div class="col-lg-6">

        <div id="approve-deactivation-step-3" style="display: none">

            <legend class="badge-step">
                <span class="badge"><?= Yii::t('app', 'STEP 3') ?></span>
            </legend>

            <?= $form->field($model, 'code', ['enableAjaxValidation' => true])->dropDownList(
                $reasonsList, ['prompt' => ' - Choose reason - ']
            )->label(Yii::t('app', 'Choose reason for rejecting deactivation request')); ?>

            <?= $form->field($model, 'description', ['enableAjaxValidation' => true])->textInput([
                'maxlength' => true,
                'class' => 'form-control form-field-short',
            ])->label(Yii::t('app', 'If other, then enter description')); ?>
        </div>

    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
