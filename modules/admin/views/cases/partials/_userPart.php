<?php

use \kartik\checkbox\CheckboxX;

?>

<h2>User</h2>

<?= $form->field($user, 'is_active')->textInput()->widget(CheckboxX::classname(), [
    'class'         => 'form-control form-field-short',
    'pluginOptions' => ['threeState' => false]
]); ?>

<?= $form->field($user, 'first_name')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>

<?= $form->field($user, 'last_name')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>

<?= $form->field($user, 'email')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>

<?= $form->field($user, 'phone')->textInput([
    'maxlength' => true,
    'class'  => 'form-control form-field-short',
]) ?>