<?php

use app\widgets\base\DetailView;
use kartik\icons\Icon;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\models\Record */
/* @var $form string */
/* @var $formatter \app\helpers\Formatter */

$user = Yii::$app->user;
$formatter = Yii::$app->formatter;

?>

<div class="record-view-full-details">

    <div class="col-xs-12">

        <div class="row">
            <div class="col-xs-6">
                <?= DetailView::widget([
                    'id' => 'case-details',
                    'title' => Yii::t('app', 'Case details'),
                    'template' => '<tr><th class="case-details-headers"><span>{label}</span></th><td>{value}</td></tr>',
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
                            'value' => sprintf('%s (%s)',
                                $formatter->asDatetime($model->infraction_date, 'php:d-m-Y H:i:s'),
                                $formatter->asElapsedTime($model->infraction_date)
                            )
                        ],
                        [
                            'label' => Yii::t('app', 'Status'),
                            'attribute' => 'statusName',
                        ],
                    ],
                ]) ?>
            </div>
            <div class="col-xs-6">
                <?= DetailView::widget([
                    'id' => 'photo-video-evidence',
                    'title' => Yii::t('app', 'Photo/Video evidence'),
                    'template' => '<tr><th class="evidence-headers"><span>{label}</span></th><td>{value}</td></tr>',
                    'model' => $model,
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'GPS Latitude'),
                            'value' => $this->render('partials/text-latitude', ['location' => $model->location]),
                        ],
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'GPS Longitude'),
                            'value' => $this->render('partials/text-longitude', ['location' => $model->location]),
                        ],
                        [
                            'label' => Yii::t('app', 'Location (nearby address)'),
                            'value' => '3410 Vaudeville Ave.',
                        ]
                    ],
                    'footer' => $this->render('../../partials/evidence', ['model' => $model])
                ]) ?>
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
