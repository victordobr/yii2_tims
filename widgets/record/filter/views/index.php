<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\frontend\models\search\Record;

/**
 * @var $model \app\modules\frontend\models\search\Record
 */
?>
<div class="panel panel-default panel-record-filter">
    <div class="panel-heading"><?= Yii::t('app', 'Filter By') ?></div>

    <div class="panel-body">

        <?php $form = ActiveForm::begin([
            'id' => 'form-record-search-filter',
            'enableClientScript' => false,
            'method' => 'GET',
            'options' => ['data-pjax' => true]
        ]); ?>

        <?= $form->field(
            $model,
            'filter_created_at'
        )->radioList($model->getCreatedAtFilters(), ['encode' => false])->label(false); ?>

        <?= $form->field($model, 'filter_status[]')->checkbox([
            'value' => Record::STATUS_INCOMPLETE,
            'label' => Yii::t('app', 'Show only incomplete records')
        ]); ?>

        <?= $form->field($model, 'filter_status[]')->checkbox([
            'value' => Record::STATUS_COMPLETE_WITH_DEACTIVATION_WINDOW,
            'label' => Yii::t('app', 'Show only records within deactivation window')
        ]); ?>

        <?= $form->field($model, 'user_id')->dropDownList($model->getUploaderList()); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>