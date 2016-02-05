<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\Log;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Log */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
?>
<div class="log-index">

    <?php $columns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'email',
        'ip_address',
        [
            'attribute' => 'category',
            'value' => function ($model) {
                return Log::eventById($model->category);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => Log::eventList(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => 150],
            ],
            'filterInputOptions' => ['placeholder' => 'Choose State'],
            'format' => 'raw',
            'headerOptions' => ['style' => 'width: 160px;']
        ],
        [
            'attribute' => 'date',
            'format' => 'datetime',
            'headerOptions' => ['style' => 'width: 200px;'],
            'filter'          => kartik\daterange\DateRangePicker::widget([
                'name'          => 'Log[date]',
                'value'         => $searchModel->date,
                'pluginOptions' => [
                    'locale'=>[
                        'format'=>'MM/DD/YYYY'
                    ],
                    'opens' => 'left'
                ]
            ]),
        ],
    ]; ?>

    <?= GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true,
        'columns' => $columns,
        'toolbar' => [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reload Grid')]) .
                '{export}'
            ],
        ],
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'panel' => [
            'type' => 'primary',
            'heading' => '<i class="glyphicon glyphicon-list"></i> ' . $this->title,
            'before' => '<em>' . Yii::t('app', '* Resize table columns just like a spreadsheet by dragging the column edges.') . '</em>',
            'after' => false,
        ]
    ]); ?>

</div>
