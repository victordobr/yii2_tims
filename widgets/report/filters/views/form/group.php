<?php

use kartik\builder\Form;
use app\enums\ReportGroup;
use kartik\form\ActiveForm;
use kartik\helpers\Html;

?>

<?php $form = \kartik\form\ActiveForm::begin([
    'id' => 'form-reports-group-by',
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientScript' => false,
    'action' => ['reports/summary-report'],
    'method' => 'GET',
    'options' => ['data-pjax' => true]
]); ?>

<div class="row">

    <?= Form::widget([
            'id' => 'filter-radio-button-group',
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'filter_group_by' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => ReportGroup::listData(),
                ],

            ],
    ]); ?>

</div>

<div class="form-group text-right">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-default btn-submit']) ?>
</div>

<?php ActiveForm::end(); ?>