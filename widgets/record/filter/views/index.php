<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\frontend\models\search\Record;

/**
 * @var $filters array
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

        <?php if (!empty($filters['statuses'])): ?>
            <?php foreach ($filters['statuses'] as $checkbox): ?>
                <?= $form->field($model, $checkbox['name'])->checkbox([
                    'label' => $checkbox['label'],
                    'value' => $checkbox['value'],
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($filters['uploader'])): ?>
            <?= $form->field($model, 'user_id')->dropDownList($model->getUploaderList()); ?>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>