<?php
use yii\widgets\ActiveForm;

/**
 * @var $filters array
 * @var $model \app\modules\frontend\models\base\Record
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

        <?php if (!empty($filters['created_at'])): ?>
            <?= $form->field(
                $model,
                'filter_created_at'
            )->radioList($filters['created_at'], ['encode' => false])->label(false); ?>
        <?php endif; ?>

        <?php if (!empty($filters['statuses'])): ?>
            <?php foreach ($filters['statuses'] as $status): ?>
                <?= $form->field($model, 'filter_status[]')->checkbox([
                    'label' => $status['label'],
                    'value' => $status['value'],
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($filters['authors'])): ?>
            <?= $form->field($model, 'filter_author_id')->dropDownList($filters['authors']); ?>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>