<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\frontend\models\search\PoliceCase $model
 */

use \yii\helpers\Html;
use \app\models\User;

$this->title = \Yii::t('app', 'Search Panel - List of uploaded records');
$clearLabel = \Yii::t('app', 'Clear Filters');
?>
<div class="user-index">


    <div class="header-title">
        <h1><?= yii\helpers\Html::encode($this->title) ?></h1>
    </div>

    <div class="white-background">
<!--        <div class="right">-->
<!--            --><?php //echo Html::a(Html::encode($clearLabel), ['search'], ['class' => 'btn btn-primary']) ?>
<!--        </div>-->

        <?php
        yii\widgets\Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
        ]);
        ?>
        <?= yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
//        'filterModel' => $model,
//        'filterModel' => $model,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'width: 50px;']
                ],
                [
                    'attribute' => 'infraction_date',
                    'headerOptions' => ['style' => 'width: 190px;']
                ],
                [
                    'label' => 'Case Number #',
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width: 180px;']
                ],
                [
                    'label' => 'Vehicle Tag #',
                    'attribute' => 'evidence.user_id',
                    'headerOptions' => ['style' => 'width: 100px;']
                ],
                [
                    'label' => 'Uploaded Date',
                    'attribute' => 'evidence.created_at',
                    'format' => 'datetime',
                    'headerOptions' => ['style' => 'width: 190px;']
                ],
                [
                    'label' => 'Uploaded By',
                    'attribute' => 'evidence.user_id',
//                    'headerOptions' => ['style' => 'width: 100px;']
                ],
//            [
//                'label' => 'Uploaded date',
//                'attribute' => 'open_date',
//                'headerOptions' => ['style' => 'width: 100px;']
//            ],
//            'infraction_date',
//            'infraction_date',
//            'infraction_date',
//            'infraction_date',
            ],
        ]);
        yii\widgets\Pjax::end();
        ?>
    </div>

    <?php $this->registerJs(
        '$("document").ready(function(){
        $("#pjax-frontend-search").on("pjax:start", function() {
            $("#pjax-frontend-search").addClass("page-loading");
        });

        $("#pjax-frontend-search").on("pjax:end", function() {
            $("#pjax-frontend-search").removeClass("page-loading");
        });

    });'
    ); ?>

</div>
