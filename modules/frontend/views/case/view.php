<?php

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\frontend\models\form\DeactivateForm;

/* @var $this yii\web\View */
/* @var $model app\models\PoliceCase */

$this->title = Yii::t('app', 'View uploaded record - Case #' . $model->id);
$user = Yii::$app->user;
?>
<div class="police-case-view">

    <div class="header-title"><h1><?= Html::encode($this->title) ?></h1></div>

    <div class="col-xs-12">

        <div class="row">
            <div class="col-xs-6">
                <h3><?= Yii::t('app', 'Case details'); ?></h3>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => Yii::t('app', 'Date case opened'),
                            'format' => 'raw',
                            'value' => $model->renderDateOpened()
                        ],
                        [
                            'label' => Yii::t('app', 'Case opened by'),
                            'format' => 'raw',
                            'value' => $model->evidence->user->getFullName()
                        ],
                        [
                            'label' => Yii::t('app', 'Vehicle TAG'),
                            'attribute' => 'evidence.license',
                        ],
                        [
                            'label' => Yii::t('app', 'Date of alleged infraction'),
                            'format' => 'raw',
                            'value' => $model->evidence->renderInfractionDate()
                        ],
                        [
                            'label' => Yii::t('app', 'Status'),
                            'attribute'=>'status.name',
                        ],
                    ],
                ]) ?>
            </div>
            <div class="col-xs-6">
                <h3><?= Yii::t('app', 'Photo/Video evidence'); ?></h3>
                <?= DetailView::widget([
                    'model' => $model->evidence,
                    'attributes' => [
                        'lat',
                        'lng',
                        [
                            'label' => Yii::t('app', 'Location (nearby address)'),
                            'value' => 'to-do'
                        ]
                    ],
                ]) ?>
                <?= $this->render('../partials/evidence', ['model' => $model->evidence]); ?>
            </div>
        </div>

        <?php if ($user->can('RequestDeactivation')): ?>
            <div class="row">
                <?= $this->render('../forms/deactivate', [
                    'action'=>Url::to(['deactivate', 'id' => $model->id]),
                    'model' => new DeactivateForm()
                ]) ?>
            </div>
        <?php endif; ?>

    </div>

</div>
