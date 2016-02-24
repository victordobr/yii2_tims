<?php

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\ActionColumn;

?>

<?php Pjax::begin([
    'id' => 'pjax-frontend-search',
    'timeout' => false,
    'enablePushState' => false,
    'formSelector' => '#form-record-reports-filter',
    'options' => ['class' => 'wrapper-grid-view',]
]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'status',
            'count',
            [
                'header' => Html::a(Icon::show('refresh', ['class' => 'fa-lg']), '#', ['class' => 'grid-view-refresh', 'title' => Yii::t('app', 'refresh grid')]),
                'class' => ActionColumn::className(),
                'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        return Html::a(
                            Icon::show('eye', ['class' => 'fa-lg']),
                            Url::to($model->viewUrl),
                            ['title' => Yii::t('app', 'View'), 'data-pjax' => '0']
                        );
                    },
                ],
            ]
        ],
        'layout'=>"\n{items}",
    ]); ?>

<?php Pjax::end(); ?>