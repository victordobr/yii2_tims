<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\enums\CaseStatus;

/* @var $this yii\web\View */
/* @var $model \app\modules\frontend\models\search\Record */
/* @var $forms array */
/* @var $formatter \app\helpers\Formatter */

$this->title = Yii::t('app', 'View uploaded record - Case #' . $model->id);
$user = Yii::$app->user;
$formatter = Yii::$app->formatter;
?>
<div class="police-case-view">

    <div class="header-title"><h1><?= Html::encode($this->title) ?></h1></div>

    <div class="col-xs-12">

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Case details'); ?></div>
                    <div class="panel-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table'],
                            'attributes' => [
                                [
                                    'label' => Yii::t('app', 'Date case opened'),
                                    'format' => 'raw',
                                    'value' => $formatter->asDatetime($model->open_date)
                                ],
                                [
                                    'label' => Yii::t('app', 'Case opened by'),
                                    'format' => 'raw',
                                    'value' => $model->user->getFullName()
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
                                    'attribute' => 'status.name',
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Photo/Video evidence'); ?></div>
                    <div class="panel-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table'],
                            'attributes' => [
                                'lat',
                                'lng',
                                [
                                    'label' => Yii::t('app', 'Location (nearby address)'),
                                    'value' => 'to-do'
                                ]
                            ],
                        ]) ?>

                        <div class="form-group col-xs-12">
                            <?= $this->render('../partials/evidence', ['model' => $model]); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php if ($model->status_id == CaseStatus::COMPLETE && $user->can('RequestDeactivation')): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('../forms/request-deactivation', [
                        'action' => Url::to(['RequestDeactivation', 'id' => $model->id]),
                        'model' => $forms['request-deactivation']
                    ]) ?>
                </div>
            </div>
        <?php elseif ($model->status_id == CaseStatus::AWAITING_DEACTIVATION && $user->can('ApproveDeactivation')): ?>

            <div class="row">
                <?= $this->render('../forms/approve-deactivation', [
                    'action' => Url::to(['ApproveDeactivation', 'id' => $model->id]),
                    'model' => $forms['approve-deactivation']
                ]) ?>
            </div>
        <?php endif; ?>

    </div>

</div>
