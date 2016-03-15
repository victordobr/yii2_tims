<?php

use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use kartik\date\DatePicker;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-record-reports-filter',
    'enableClientScript' => false,
    'method' => 'GET',
    'options' => ['data-pjax' => true]
]); ?>

<?php if ($created = $model->getCreatedAtFilters()): ?>

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
                            'items' => $created,
                            'options' => [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return Html::tag('div',
                                        Html::label(
                                            Html::input('radio', $name, $value, ['checked' => $checked]) . ' ' . $label, null, [
                                            'class' => 'search-filter-list-label input-group-sm'
                                        ]), ['class' => 'radio']);
                                },
                            ],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php endif; ?>

    <div class="row">
        <?= Form::widget([
            'id' => 'filter-date-opened',
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                [
                    'label' => Yii::t('app', 'Select date range to display'),
                    'labelOptions' => ['class' => 'search-filter-label'],
                    'columns' => 12,
                    'attributes' => [
                        'filter_created_at_from' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DatePicker::classname(),
                            'options' => [
                                'layout' => '{input}{remove}',
                                'size' => 'sm',
                                'options' => [
                                    'placeholder' => 'from',
                                    'todayHighlight' => true,
                                ],
                                'pluginOptions' => [
                                    'format' => Yii::$app->settings->get('date.view.format'),
                                    'autoclose' => true,
                                ]
                            ],
                            'columnOptions' => [
                                'colspan' => 6,
                            ],
                        ],
                        'filter_created_at_to' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DatePicker::classname(),
                            'options' => [
                                'layout' => '{input}{remove}',
                                'size' => 'sm',
                                'options' => [
                                    'placeholder' => 'to',
                                    'todayHighlight' => true,
                                ],
                                'pluginOptions' => [
                                    'format' => Yii::$app->settings->get('date.view.format'),
                                    'autoclose' => true,
                                ]
                            ],
                            'columnOptions' => [
                                'colspan' => 6,
                            ],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php if ($authors = $model->getAuthorFilters()): ?>
    <div class="row">
        <?= Form::widget([
            'id' => 'filter-record-state',
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                [
                    'label' => $model->getAttributeLabel('filter_author_id'),
                    'labelOptions' => ['class' => 'search-filter-label'],
                    'columns' => 1,
                    'attributes' => [
                        'filter_author_id' => [
                            'fieldConfig' => ['options' => ['class' => 'form-group form-group-sm']],
                            'type' => Form::INPUT_DROPDOWN_LIST,
                            'items' => $authors,
                            'options' => [
                                'prompt' => Yii::t('app', 'Officer name / ID')
                            ],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php endif; ?>

    <div class="row">
        <div class="form-group text-right">
            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-sm btn-default btn-reset']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>