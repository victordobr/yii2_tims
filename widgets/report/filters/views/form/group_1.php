<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use app\enums\ReportGroup;
use kartik\helpers\Html;

//\app\base\Module::pa(ReportGroup::listData(),1);
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-reports-filter',
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientScript' => false,
    'method' => 'GET',
    'options' => ['data-pjax' => true]
]); ?>

    <div class="row">

        <?= Html::radioButtonGroup('group_by', 1, ReportGroup::listData());?>

    </div>

<?php ActiveForm::end(); ?>