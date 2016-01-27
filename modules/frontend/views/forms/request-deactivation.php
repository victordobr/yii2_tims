<?php
/**
 * @var $action string
 * @var $model \app\modules\frontend\models\form\RequestDeactivateForm
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>
<div class="col-xs-12">

    <h3><?= Yii::t('app', 'Request deactivation'); ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'request-deactivation-form',
        'action' => $action,
        'enableClientValidation' => true,
        'options' => [
            'class' => 'form-horizontal',
            'data-pjax' => true
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'code')->dropDownList([10 => 10]); ?>

    <?= $form->field($model, 'description')->textInput([
        'maxlength' => true,
        'class' => 'form-control form-field-short',
    ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-5 col-lg-5">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
