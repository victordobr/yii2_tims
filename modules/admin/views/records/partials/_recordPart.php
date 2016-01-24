<?php

use kartik\date\DatePicker;

?>

<?= $form->field($record, 'lat')->textInput(['maxlength' => true]) ?>

<?= $form->field($record, 'lng')->textInput(['maxlength' => true]) ?>

<?=  $form->field($record, 'infraction_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => Yii::$app->params['date.view.format'],
        'autoclose'=>true
    ]
]); ?>

<?=  $form->field($record, 'open_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => Yii::$app->params['date.view.format'],
        'autoclose'=>true
    ]
]); ?>

<?= $form->field($record, 'state_id')->dropDownList(
    app\enums\States::listData()
); ?>

<?= $form->field($record, 'license')->textInput(['maxlength' => true]) ?>

<?= $form->field($record, 'ticket_fee')->textInput() ?>

<?=  $form->field($record, 'ticket_payment_expire_date')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'orientation' => 'bottom',
        'format' => Yii::$app->params['date.view.format'],
        'autoclose'=>true
    ]
]); ?>

<?= $form->field($record, 'comments')->textarea(['rows' => 6]) ?>

<?= $form->field($record, 'user_plea_request')->textarea(['rows' => 6]) ?>

<?= $form->field($record, 'status_id')->dropDownList(
    \app\models\CaseStatus::find()->select(['name', 'id'])->indexBy('id')->column()
); ?>