<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\frontend\models\search\PoliceCase $model
 */

use \yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;

?>

<div id="wrapper-print-qc">

    <?php Pjax::begin([
        'id' => 'pjax-print-qc',
        'timeout' => false,
        'enablePushState' => false,
        'formSelector' => '#form-record-search-filter'
    ]); ?>

    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary pull-right qc-confirm-selected" disabled="disabled"><?= Yii::t('app', 'Confirm') ?></button>
        </div>
    </div>

    <?= GridView::widget([
        'id' => 'grid-print-qc',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'kartik\grid\CheckboxColumn',
            ],
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'infraction_date:datetime',
            'id',
            'license',
            'status_id',
            'elapsedTime',
            [
                'class' => ActionColumn::className(),
                'template' => '{review}',
                'buttons' => [
                    'review' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to(['records/review', 'id' => $model->id]),
                            ['title' => Yii::t('app', 'Review'), 'data-pjax' => '0']
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary pull-right qc-reject-selected" disabled="disabled"><?= Yii::t('app', 'Reject') ?></button>
        </div>
    </div>

    <?php Pjax::end(); ?>

</div>