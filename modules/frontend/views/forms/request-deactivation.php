<?php
/**
 * @var $action string
 * @var $reasonsList array
 * @var $model \app\modules\frontend\models\form\RequestDeactivateForm
 */

use yii\helpers\Html;
use app\widgets\base\ActiveForm;

?>

<div class="col-lg-12">

    <?php $form = ActiveForm::begin([
        'id' => 'request-deactivation-form',
        'title' => Yii::t('app', 'Request deactivation'),
        'action' => $action,
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'options' => [
            'class' => 'form-horizontal',
            'data-pjax' => true
        ],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-12\">{label}\n{input}</div>\n<div class=\"col-lg-11\">{error}</div>",
        ],
    ]); ?>

    <fieldset>

        <legend class="badge-step">
            <span class="badge"><?= Yii::t('app', 'STEP 1') ?></span>
        </legend>

        <?= $form->field($model, 'code', ['enableAjaxValidation' => true])->dropDownList(
            $reasonsList, ['prompt' => ' - Choose reason - ']
        )->label(Yii::t('app', 'Choose reason for deactivation')); ?>

        <?= $form->field($model, 'description', ['enableAjaxValidation' => true])->textInput([
            'maxlength' => true,
            'class' => 'form-control form-field-short',
        ])->label(Yii::t('app', 'If other, then enter description')) ?>

    </fieldset>

    <fieldset>

        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

    </fieldset>

    <?php ActiveForm::end(); ?>

</div>
