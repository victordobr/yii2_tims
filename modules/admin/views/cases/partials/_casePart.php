<?php

use kartik\date\DatePicker;
use app\models\CaseStatus;

?>

<h2>Case</h2>

<?= $form->field($case, 'status_id')->dropDownList(
    CaseStatus::find()->select(['StatusName', 'id'])->indexBy('id')->column()
); ?>

<?= $form->field($case, 'created_at')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => 'dd/mm/yyyy',
        'autoclose'=>true
    ]
]); ?>

<?=  $form->field($case, 'open_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => 'dd/mm/yyyy',
        'autoclose'=>true
    ]
]); ?>

<?= $form->field($case, 'officer_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => 'dd/mm/yyyy',
        'autoclose'=>true
    ]
]); ?>

<?= $form->field($case, 'mailed_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => 'dd/mm/yyyy',
        'autoclose'=>true
    ]
]); ?>