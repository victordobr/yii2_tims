<?php
/**
 * @var $action string
 * @var $model \app\modules\frontend\models\form\DeactivateForm
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app', 'Request deactivation'); ?></div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin([
                'id' => 'deactivate-form',
                'action' => $action,
                'enableClientValidation' => true,
                'options' => [
                    'class' => 'form-horizontal',
                    'data-pjax' => true
                ],
                'fieldConfig' => [
                    'template' => "<div class=\"col-lg-12\">{label}\n{input}</div>\n<div class=\"col-lg-11 col-lg-offset-1\">{error}</div>",
                ],
            ]); ?>

            <div class="col-lg-6">

                <div class="form-group badge-step">
                    <div class="col-lg-12">
                        <span class="badge"><?= Yii::t('app', 'STEP 1') ?></span>
                    </div>
                </div>

                <?= $form->field($model, 'requested_by')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                    'disabled' => 'disabled'
                ]); ?>

                <?= $form->field($model, 'review_reason')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                    'disabled' => 'disabled'
                ]); ?>

                <div class="form-group badge-step">
                    <div class="col-lg-12">
                        <span class="badge"><?= Yii::t('app', 'STEP 2') ?></span>
                    </div>
                </div>

                <?= $form->field($model, 'action')->radioList($model->actions(), [
                    'onclick' => 'js:$("#approve-deactivation-step-3").toggle($(this).find("input[type=radio]:checked").val() == "reject");'
                ])->label(false); ?>

            </div>

            <div id="approve-deactivation-step-3" class="col-lg-6" style="display: none">

                <div class="form-group badge-step">
                    <div class="col-lg-12">
                        <span class="badge"><?= Yii::t('app', 'STEP 3') ?></span>
                    </div>
                </div>

                <?= $form->field($model, 'code')->dropDownList([10 => 10]); ?>

                <?= $form->field($model, 'description')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary col-lg-1']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
