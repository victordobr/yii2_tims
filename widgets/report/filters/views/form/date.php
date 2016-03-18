<?php

use kartik\date\DatePicker;
use kartik\builder\Form;

?>

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
