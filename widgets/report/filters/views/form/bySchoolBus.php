<?php
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\helpers\Html;
use kartik\select2\Select2;d

//\app\base\Module::pa($model->getBusNumberList(),1);
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-record-reports-filter',
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientScript' => false,
    'method' => 'GET',
    'options' => ['data-pjax' => true]
]); ?>

    <div class="row">
        <?= $form->field($model, 'filter_bus_number')->label(false)->widget(Select2::classname(), [
                'data' => $model->getBusNumberList(),
                'options' => [
                    'placeholder' => 'Select a bus number ...',
                ],
                'pluginOptions' => [
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'multiple' => true,
                    'maximumInputLength' => 10,
                    'allowClear' => true,
                ],
            ]);
        ?>
    </div>

    <div class="row">
        <div class="form-group text-right">
            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-sm btn-default btn-reset']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>