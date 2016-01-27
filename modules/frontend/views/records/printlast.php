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

$this->title = \Yii::t('app', 'SEARCH PANEL – LIST OF RECORDS TO QC');
$clearLabel = \Yii::t('app', 'Clear Filters');
?>
<div class="user-index">


    <div class="header-title">
        <h1><?= yii\helpers\Html::encode($this->title) ?></h1>
    </div>
    <a id="modal-button-" class="img-pic" data-toggle="modal" data-target=""
       title="">PRINT</a>
    <a id="modal-button-" class="img-pic" data-toggle="modal" data-target=""
       title="">PRINT ALL</a>
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
        <?= kartik\grid\GridView::widget([
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
//                [
//                    'label' => 'Uploaded Date',
//                    'attribute' => 'created_at',
////                    'format' => 'datetime',
//                    'headerOptions' => ['style' => 'width: 190px;']
//                ],
                [
                    'label' => 'Record Status',
                    'attribute' => 'status_id',
                    'headerOptions' => ['style' => 'width: 100px;']
                ],
//                [
//                    'attribute' => 'status_id',
//                    'value' => function ($model) {
//                        return $model->status_id;
//                    },
//                    'filterType' => GridView::FILTER_SELECT2,
//                    'filter' => ArrayHelper::map(\app\models\CaseStatus::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => 'Any author'],
//                    'format' => 'raw'
//                ],
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