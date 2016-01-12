<?php

use kartik\date\DatePicker;

?>

<h2>Evidence</h2>

<?= $form->field($evidence, 'license')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>

<?= $form->field($evidence, 'lat')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>

<?= $form->field($evidence, 'lng')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>

<?= $form->field($evidence, 'state_id')->dropDownList(
    app\enums\States::listData()
); ?>

<?= $form->field($evidence, 'infraction_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => 'dd/mm/yyyy',
        'autoclose'=>true
    ]
]); ?>

<?= $form->field($evidence, 'created_at')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => 'dd/mm/yyyy',
        'autoclose'=>true
    ]
]); ?>