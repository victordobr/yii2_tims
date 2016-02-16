<?php

use app\widgets\base\DetailView;

/* @var $this yii\web\View */
/* @var $model \app\models\Record */
/* @var $form string */
/* @var $formatter \app\helpers\Formatter */

$user = Yii::$app->user;
$formatter = Yii::$app->formatter;

?>

<div class="police-case-view">

    <div class="col-xs-12">

        <div class="row">

            <div class="col-xs-6">
                <?= DetailView::widget([
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
                            'value' => $model->statusHistory->author->getFullName()
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

            <div class="col-xs-6">
                <?= DetailView::widget([
                    'title'=>Yii::t('app', 'Photo/Video evidence'),
                    'model' => $model,
                    'options' => ['class' => 'table'],
                    'attributes' => [
                        [
                            'label' => Yii::t('app', 'GPS Latitude'),
                            'value' => $model->location->lat_dms . ' ' . $model->location->lat_ddm,
                        ],
                        [
                            'label' => Yii::t('app', 'GPS Longitude'),
                            'value' => $model->location->lng_dms . ' ' . $model->location->lng_ddm,
                        ],
                        [
                            'label' => Yii::t('app', 'Location (nearby address)'),
                            'value' => 'to-do'
                        ]
                    ],
                    'footer' => $this->render('../../partials/evidence', ['model' => $model])
                ]) ?>

            </div>

        </div>

        <?php if (!empty($form)): ?>
            <div class="row"><?= $form ?></div>
        <?php endif; ?>

    </div>

</div>
