<?php
/**
 * @var $action string
 * @var $reasons array
 * @var $model \app\modules\frontend\models\form\MakeDeterminationForm
 */

use yii\helpers\Html;
use app\widgets\base\ActiveForm;

?>

<div class="col-lg-12">

    <?php $form = ActiveForm::begin([
        'title' => Yii::t('app', 'Change determination'),
        'id' => 'change-determination-form',
        'action' => $action,
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'options' => [
            'class' => 'form-horizontal',
            'data-pjax' => true
        ],
        'fieldConfig' => [
            'template' => '<div class="col-lg-12">{label}{input}{error}</div>',
        ],
    ]); ?>


    <fieldset class="col-lg-12">

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 1') ?></span>
        </legend>

        <?= $form->field($model, 'confirm')->checkbox(['labelOptions' => ['class' => 'font-normal']]); ?>

    </fieldset>


    <fieldset class="col-lg-6">

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 2') ?></span>
        </legend>

        <div class="row">

            <div class="col-lg-7">
                <?= $form->field($model, 'previous_determination')->textInput(['disabled' => 'disabled']); ?>
            </div>

            <div class="col-lg-5">
                <?= $form->field($model, 'decision_by')->textInput(['disabled' => 'disabled']); ?>
            </div>

        </div>

        <?= $form->field($model, 'action')->radioList($model->actions(), ['itemOptions'=>['labelOptions'=>['class' => 'radio-list-label']]]); ?>

    </fieldset>

    <fieldset class="col-lg-6">

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 3') ?></span>
        </legend>

        <?= $form->field($model, 'code', ['enableAjaxValidation' => true])->dropDownList(
            $reasons, ['prompt' => ' - Choose reason - ']
        ); ?>

        <?= $form->field($model, 'description', ['enableAjaxValidation' => true])->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ]); ?>

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 4') ?></span>
        </legend>

        <?= $form->field($model, 'officer_pin', ['enableAjaxValidation' => true])->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ]); ?>

    </fieldset>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
