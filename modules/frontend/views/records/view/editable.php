<?php

use app\widgets\base\DetailView;
use kartik\icons\Icon;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $model \app\models\Record
 * @var $formatter \app\helpers\Formatter
 * @var $statuses array
 */

$formatter = Yii::$app->formatter;
?>

<div id="record-editable-view">

    <div class="col-xs-12">

        <div class="row">
            <div class="col-xs-6">
                <?php Pjax::begin([
                    'id' => 'pjax-case-details',
                    'timeout' => false,
                    'enablePushState' => false,
                    'formSelector' => '#form-case-details',
                    'options' => ['class' => 'wrapper-detail-view',]
                ]); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'form-case-details',
                    'method' => 'GET',
                    'enableClientScript' => false,
                    'options' => ['data-pjax' => true],
                    'fieldConfig' => [
                        'template' => '<div class="col-lg-12">{label}{input}{error}</div>',
                    ],
                ]); ?>
                <?= DetailView::widget([
                    'id' => 'case-details',
                    'editable' => true,
                    'title' => Yii::t('app', 'Case details'),
                    'model' => $model,
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        [
                            'label' => Yii::t('app', 'Date case opened'),
                            'attribute' => 'created_at',
                        ],
                        [
                            'label' => Yii::t('app', 'Case opened by'),
                            'value' => $model->statusHistory->author->getFullName(),
                        ],
                        [
                            'label' => Yii::t('app', 'Vehicle TAG'),
                            'attribute' => 'license',
                        ],
                        [
                            'label' => Yii::t('app', 'Date of alleged infraction'),
                            'format' => 'raw',
                            'value' => sprintf('%s (%s)', $formatter->asDatetime($model->infraction_date, 'php:d-m-Y H:i:s'), $formatter->asElapsedTime($model->infraction_date))
                        ],
                        [
                            'label' => Yii::t('app', 'Status'),
                            'attribute' => 'statusName',
                        ],
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'Change record state to'),
                            'value' => $form->field($model, 'status_id', [
                                'options' => ['class' => 'form-group form-group-sm'],
                            ])->dropDownList($statuses)->label(false),
                        ]
                    ],
                ]) ?>
                <?php ActiveForm::end(); ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="col-xs-6">
                <?php Pjax::begin([
                    'id' => 'pjax-photo-video-evidence',
                    'timeout' => false,
                    'enablePushState' => false,
                    'formSelector' => '#form-photo-video-evidence',
                    'options' => ['class' => 'wrapper-detail-view',]
                ]); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'form-photo-video-evidence',
                    'enableClientScript' => false,
                    'method' => 'GET',
                    'options' => ['data-pjax' => true],
                    'fieldConfig' => [
                        'template' => '<div class="col-lg-12">{label}{input}{error}</div>',
                    ],
                ]); ?>
                <?= DetailView::widget([
                    'id' => 'photo-video-evidence',
                    'editable' => true,
                    'title' => Yii::t('app', 'Photo/Video evidence'),
                    'model' => $model,
                    'template' => '<tr><th class="evidence-headers">{label}</th><td>{value}</td></tr>',
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'GPS Latitude'),
                            'value'=> $this->render('partials/input-latitude', [
                                'form' => $form,
                                'location' => $model->location,
                            ]),
                        ],
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'GPS Longitude'),
                            'value'=> $this->render('partials/input-longitude', [
                                'form' => $form,
                                'location' => $model->location,
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Location (nearby address)'),
                            'value' => '3410 Vaudeville Ave.',
                        ]
                    ],
                    'footer' => $this->render('../../partials/evidence', ['model' => $model])
                ]) ?>
                <?php ActiveForm::end(); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?= DetailView::widget([
                    'id' => 'violator-details',
                    'title' => Yii::t('app', 'Violator details'),
                    'max_rows' => 5,
                    'model' => $model,
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        [
                            'label' => Yii::t('app', 'Operator License No. / Class'),
                            'value' => 'D647362 (CLASS 5)',
                        ],
                        [
                            'label' => Yii::t('app', 'License Issuer / Expiry'),
                            'value' => 'GA / 23 AUG 2017',
                        ],
                        [
                            'label' => Yii::t('app', 'Vehicle Make / Year'),
                            'value' => 'HONDA 2006'
                        ],
                        [
                            'label' => Yii::t('app', 'Style / Color'),
                            'value' => 'CIVIC TYPE R (PEARL WHITE)',
                        ],
                        [
                            'label' => Yii::t('app', 'Registration No./Year/State'),
                            'value' => 'H7D 7J3 (2015/TX)',
                        ],

                        [
                            'label' => Yii::t('app', 'Operator License No. / Class'),
                            'value' => 'D647362 (CLASS 5)',
                        ],
                        [
                            'label' => Yii::t('app', 'License Issuer / Expiry'),
                            'value' => 'GA / 23 AUG 2017',
                        ],
                        [
                            'label' => Yii::t('app', 'Vehicle Make / Year'),
                            'value' => 'HONDA 2006'
                        ],
                        [
                            'label' => Yii::t('app', 'Style / Color'),
                            'value' => 'CIVIC TYPE R (PEARL WHITE)',
                        ],
                        [
                            'label' => Yii::t('app', 'Registration No./Year/State'),
                            'value' => 'H7D 7J3 (2015/TX)',
                        ],
                        [
                            'label' => Yii::t('app', 'Registration No./Year/State'),
                            'value' => 'H7D 7J3 (2015/TX)',
                        ],
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?= DetailView::widget([
                    'id' => 'citation-details',
                    'title' => Yii::t('app', 'Citation details'),
                    'model' => $model,
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        [
                            'label' => Yii::t('app', 'Citation No.'),
                            'value' => '094675',
                        ],
                        [
                            'label' => Yii::t('app', 'Issue By'),
                            'value' => 'Caroline Hunter (JCPD 2468)',
                        ],
                        [
                            'label' => Yii::t('app', 'Payment Due'),
                            'value' => '10 Jan, 2016'
                        ],
                    ],
                    'aside' => $this->render('../../partials/icon', [
                            'class' => 'col-sm-6 wrapper-dollar-amount',
                            'icon' => Icon::show('usd', ['class' => 'fa-sm']) . '1000',
                            'text' => 'Violation Fine'
                        ]) . $this->render('../../partials/icon', [
                            'class' => 'col-sm-6',
                            'icon' => Icon::show('file-text-o', ['class' => 'fa-lg']),
                            'text' => 'Violation Fine'
                        ])
                ]) ?>
            </div>
        </div>

    </div>

</div>
