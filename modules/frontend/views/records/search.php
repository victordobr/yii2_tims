<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
?>

<div class="user-index">

    <div class="white-background">

        <?php
        Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
            'formSelector' => '#form-record-search-filter-basic, #form-record-search-filter-advanced'
        ]);
        ?>
        <?= GridView::widget([
            'id' => 'record-grid-search',
            'dataProvider' => $dataProvider,
            'summary' => Yii::t('app', '<div class="summary">Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{record} other{records}}.</div>'),
            'columns' => [
                'id',
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'infraction_date',
                    'format' => 'date',
                ],
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
                    'class' => ActionColumn::className(),
                    'template'=>'{review}',
                    'buttons'=>[
                        'review' => function ($url, $model) {
                            return Html::a(
                                Icon::show('eye', ['class' => 'fa-lg']),
                                Url::to(['review', 'id' => $model->id]),
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
