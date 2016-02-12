<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\modules\frontend\models\search\Record
 * @var $filters array
 */

use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-record-search-filter-basic',
    'enableClientScript' => false,
    'method' => 'GET',
    'options' => ['data-pjax' => true]
]); ?>

<?php if (!empty($filters['created_at'])): ?>

    <div class="row">
        <?= Form::widget([
            'id' => 'filter-case-opened',
            'model' => $model,
            'form' => $form,
            'attributes' => [
                [
                    'labelOptions' => ['class' => 'hide'],
                    'columns' => 1,
                    'attributes' => [
                        'filter_created_at' => [
                            'label' => null,
                            'type' => Form::INPUT_RADIO_LIST,
                            'items' => $model->getCreatedAtFilters(),
                            'options' => [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return Html::tag('div',
                                        Html::label(
                                            Html::input('radio', $name, $value, ['checked' => $checked]) . ' ' . $label, null, [
                                            'class' => 'search-filter-list-label input-group-sm'
                                        ]), ['class' => 'radio']);
                                },
                            ],
                            'columnOptions' => [
                            ],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php endif; ?>

<?php if (!empty($filters['statuses'])): ?>

    <div class="row">
        <?= Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                [
                    'labelOptions' => ['class' => 'hide'],
                    'attributes' => [
                        'filter_status' => [
                            'type' => Form::INPUT_CHECKBOX_LIST,
                            'items' => ArrayHelper::map($filters['statuses'], 'value', 'label'),
                            'options' => [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return Html::tag('div',
                                        Html::label(
                                            Html::input(Form::INPUT_CHECKBOX, $name, $value) . ' ' . $label, null, [
                                            'class' => 'search-filter-list-label input-group-sm'
                                        ]), ['class' => Form::INPUT_CHECKBOX]);
                                },
                            ],
                        ]
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php endif; ?>

<?php if (!empty($filters['authors'])): ?>
    <div class="row">
        <?= Form::widget([
            'id' => 'filter-record-state',
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                [
                    'label' => Yii::t('app', 'Uploaded by'),
                    'labelOptions' => ['class' => 'search-filter-label'],
                    'columns' => 1,
                    'attributes' => [
                        'filter_author_id' => [
                            'fieldConfig' => ['options' => ['class' => 'form-group form-group-sm']],
                            'type' => Form::INPUT_DROPDOWN_LIST,
                            'items' => $filters['authors'],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php endif; ?>

<?php ActiveForm::end(); ?>