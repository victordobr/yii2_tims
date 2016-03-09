<?php

use kartik\builder\Form;
use app\enums\ReportGroup;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
//\app\base\Module::pa($model->filter_group_id,1);
$model->filter_group_id =1;
?>

<?php $form = \kartik\form\ActiveForm::begin([
    'id' => 'form-reports-group-by',
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientScript' => false,
    'action' => ['reports/summary-report'],
    'method' => 'get',
    'options' => ['data-pjax' => true]
]); ?>

<div class="row">

    <?= Form::widget([
            'id' => 'filter-radio-button-group',
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'filter_group_id' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => ReportGroup::listData(),
                    'columnOptions' => [
                        'class' => 'text-center',
                    ],
                ],

            ],
        'attributeDefaults' => [
            'filter_group_id' => 1,
        ]
    ]); ?>

</div>

<div class="form-group text-right">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-default btn-submit']) ?>
</div>

<?php ActiveForm::end(); ?>