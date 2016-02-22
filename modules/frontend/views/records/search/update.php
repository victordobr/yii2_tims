<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $provider
 */

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\SerialColumn;
use kartik\grid\ActionColumn;
?>

<div class="record-update-index">

    <div class="white-background">

        <?php Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
            'formSelector' => '#form-record-search-filter-basic, #form-record-search-filter-advanced',
            'options' => ['class' => 'wrapper-grid-view',]
        ]); ?>

        <?= GridView::widget([
            'id' => 'record-grid-update',
            'dataProvider' => $provider,
            'columns' => [
                [
                    'class' => SerialColumn::className(),
                ],
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'infraction_date',
                    'format' => 'date',
                ],
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'id',
                ],
                'license',
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'status_id',
                ],
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'elapsedTime',
                ],
                [
                    'header' => Html::a(Icon::show('refresh', ['class' => 'fa-lg']), '#', ['class' => 'grid-view-refresh', 'title' => Yii::t('app', 'refresh grid')]),
                    'class' => ActionColumn::className(),
                    'template'=>'{review}',
                    'buttons'=>[
                        'review' => function ($url, $model) {
                            return Html::a(
                                Icon::show('eye', ['class' => 'fa-lg']),
                                Url::to(['UpdateView', 'id' => $model->id]),
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
