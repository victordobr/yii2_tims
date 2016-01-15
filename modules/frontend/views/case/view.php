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
                        'open_date',
                        'officer_date',
                        'officer_pin',
                        'officer_id',
                        [
                            'attribute'=>'status.name',
                            'label' => Yii::t('app', 'Status')
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
                        'state_id',
                    ],
                ]) ?>
                <?= $this->render('../partials/evidence', ['model' => $model->evidence]); ?>
            </div>
        </div>

        <?php if ($user->can('RequestDeactivation')): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render('../forms/deactivate', [
                        'action'=>Url::to(['deactivate', 'id' => $model->id]),
                        'model' => new DeactivateForm()
                    ]) ?>
                </div>
            </div>
        <?php endif; ?>

    </div>


</div>
