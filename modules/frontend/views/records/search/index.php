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

<div class="user-index">

    <div class="white-background">

        <?php Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
            'formSelector' => '#form-record-search-filter-basic, #form-record-search-filter-advanced',
            'options' => ['class' => 'wrapper-grid-view',]
        ]); ?>

        <?= GridView::widget([
            'id' => 'record-grid-search',
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
                'id',
                'license',
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'created_at',
                    'format' => 'date',
                ],
                'author',
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'elapsedTime',
                ],
                [
                    'header' => Html::a(Icon::show('refresh', ['class' => 'fa-lg']), '#', ['class' => 'grid-view-refresh', 'title' => Yii::t('app', 'refresh grid')]),
                    'class' => ActionColumn::className(),
                    'template'=>'{view}',
                    'buttons'=>[
                        'view' => function ($url, $model) {
                            return Html::a(
                                Icon::show('eye', ['class' => 'fa-lg']),
                                Url::to(['SearchView', 'id' => $model->id]),
                                ['title' => Yii::t('app', 'View'), 'data-pjax' => '0']
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
