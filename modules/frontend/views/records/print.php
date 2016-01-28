<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\frontend\models\search\PoliceCase $model
 */

use \yii\helpers\Html;
use \app\models\User;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


$this->title = \Yii::t('app', 'SEARCH PANEL – LIST OF RECORDS PENDING PRINT');
$clearLabel = \Yii::t('app', 'Clear Filters');
?>
<div class="user-index">
    <div class="header-title">
        <h1><?= yii\helpers\Html::encode($this->title) ?></h1>
    </div>
    <?php $this->registerJs("
    $('#print-preview').on('click', function(e) {

        var keys = $('#grid-record-print').yiiGridView('getSelectedRows');

        window.location.href = \"printtemp?\" +  $.param({ids:keys});

    });

    "); ?>
    <a href="#" id="print-preview" class="btn btn-info" data-toggle="modal" data-target=""
       title="">PRINT</a>

    <div class="white-background">

        <?php
        yii\widgets\Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
        ]);
        ?>
        <?= kartik\grid\GridView::widget([
            'id' => 'grid-record-print',
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                ],
                [
                    'class' => \kartik\grid\ActionColumn::className(),
                    'template'=>'{review}',
                    'buttons'=>[
                        'review' => function ($url, $model) {
                            return \yii\helpers\Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                \yii\helpers\Url::to(['records/review', 'id' => $model->id]),
                                ['title' => Yii::t('app', 'Review'), 'data-pjax' => '0']
                            );
                        },
                    ],
                ],

                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'width: 50px;']
                ],
                [
                    'attribute' => 'infraction_date',
//                    'format' => 'datetime',
                    'headerOptions' => ['style' => 'width: 190px;']
                ],
                [
                    'label' => 'Case Number #',
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width: 180px;']
                ],
                [
                    'label' => 'Vehicle Tag #',
                    'attribute' => 'license',
                    'headerOptions' => ['style' => 'width: 100px;']
                ],

                [
                    'label' => 'Record Status',
                    'attribute' => 'status_id',
                    'headerOptions' => ['style' => 'width: 100px;']
                ],

                [
                    'label' => 'Elapsed time, days',
                    'attribute' => 'elapsedTime',
                    'headerOptions' => ['style' => 'width: 50px;']
                ],


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