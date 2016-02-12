<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\modules\frontend\models\search\Record
 * @var $filters array
 */

use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use kartik\builder\Form;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-record-search-filter-advanced',
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientScript' => false,
    'method' => 'GET',
    'options' => ['data-pjax' => true]
]); ?>

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

    <div class="row">
        <?= Form::widget([
            'id' => 'filter-elapsed-time',
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                [
                    'label' => false,
                    'columns' => 12,
                    'attributes' => [
                        [
                            'type' => Form::INPUT_RAW,
                            'value' => Yii::t('app', 'Select elapsed time'),
                            'columnOptions' => [
                                'colspan' => 7,
                                'class' => 'search-filter-label',
                            ],
                        ],
                        'filter_elapsed_time_x_days' => [
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'X',
                                'maxlength' => 3,
                            ],
                            'columnOptions' => [
                                'colspan' => 3,
                                'class' => 'row',
                            ],
                        ],
                        [
                            'type' => Form::INPUT_RAW,
                            'value' => Yii::t('app', 'days'),
                            'columnOptions' => [
                                'class' => 'search-filter-label',
                            ],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

    <div class="row">
        <?= Form::widget([
            'id' => 'filter-record-state',
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                [
                    'label' => Yii::t('app', 'Select record state'),
                    'labelOptions' => ['class' => 'search-filter-label'],
                    'columns' => 1,
                    'attributes' => [
                        'filter_state' => [
                            'type' => Form::INPUT_DROPDOWN_LIST,
                            'options' => ['prompt' => Yii::t('app', 'Code - state description')],
                            'items' => $model->getRecordStatuses(),
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

    <div class="row">
        <?= Form::widget([
            'id' => 'filter-case-number',
            'model' => $model,
            'form' => $form,
            'attributes' => [
                [
                    'label' => Yii::t('app', 'View a specific case'),
                    'labelOptions' => ['class' => 'search-filter-label'],
                    'columns' => 1,
                    'attributes' => [
                        'filter_case_number' => [
                            'type' => Form::INPUT_TEXT,
                            'options' => ['placeholder' => Yii::t('app', 'Case No #')],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

    <div class="row">
        <?= Form::widget([
            'id' => 'filter-smart-search',
            'model' => $model,
            'form' => $form,
            'attributes' => [
                [
                    'label' => Yii::t('app', 'SMART search'),
                    'labelOptions' => ['class' => 'search-filter-label'],
                    'columns' => 1,
                    'attributes' => [
                        'filter_smart_search_text' => [
                            'type' => Form::INPUT_TEXT,
                            'options' => ['placeholder' => Yii::t('app', 'Freeform alphanumeric text')],
                        ],
                        'filter_smart_search_type' => [
                            'type' => Form::INPUT_RADIO_LIST,
                            'items' => $model->getSmartSearchTypes(),
                            'options' => [
                                'inline' => true,
                                'labelOptions' => ['class' => 'search-filter-label'],
                            ],
                            'columnOptions' => [
                                'class' => 'text-center',
                            ],
                        ],
                    ]
                ]
            ]
        ]); ?>
    </div>

<?php ActiveForm::end(); ?>