<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

?>

<?= $this->render('partials/_filterPanel', ['model' => $model]); ?>

<?php Pjax::begin([
    'id' => 'pjax-frontend-report',
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
        [
            'attribute' => 'detailLink',
            'format' => 'html',
        ],
    ],
    'layout'=>"\n{items}",
]); ?>

<?php Pjax::end(); ?>
