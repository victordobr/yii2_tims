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

    <div class="white-background">

        <?php
        yii\widgets\Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
            'formSelector' => '#form-record-search-filter'
        ]);
        ?>
        <?= yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'label' => '#',
                    'attribute' => 'id',
//                    'headerOptions' => ['style' => 'width: 50px;']
                ],
                [
                    'attribute' => 'infraction_date',
                    'format' => 'date',
//                    'headerOptions' => ['style' => 'width: 80px;']
                ],
                [
                    'label' => 'Vehicle Tag #',
                    'attribute' => 'license',
//                    'headerOptions' => ['style' => 'width: 80px;']
                ],
                [
                    'label' => 'Uploaded Date',
                    'attribute' => 'created_at',
                    'format' => 'date',
//                    'headerOptions' => ['style' => 'width: 80px;']
                ],
                [
                    'label' => 'Uploaded By',
                    'attribute' => 'fullName',
//                    'headerOptions' => ['style' => 'width: 100px;']
                ],
                [
                    'label' => 'Elapsed time, days',
                    'attribute' => 'elapsedTime',
//                    'headerOptions' => ['style' => 'width: 20px;']
                ],
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'template'=>'{review}',
                    'buttons'=>[
                        'review' => function ($url, $model) {
                            return \yii\helpers\Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                \yii\helpers\Url::to(['review', 'id' => $model->id]),
                                ['title' => Yii::t('app', 'Review'), 'data-pjax' => '0']
                            );
                        },
                    ],
                ]
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
