<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\enums\States;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Record */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Records');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-manage">

    <?php $columns = [
        [
            'label' => '#',
            'attribute' => 'id',
            'headerOptions' => ['style' => 'width: 100px;']
        ],
        [
            'attribute' => 'infraction_date',
            'format' => 'date',
            'headerOptions' => ['style' => 'width: 100px;']
        ],
        [
            'attribute' => 'state_id',
            'value' => function ($model) {
                return States::labelById($model->state_id);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => States::listData(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => 150],
            ],
            'filterInputOptions' => ['placeholder' => 'Choose State'],
            'format' => 'raw',
            'headerOptions' => ['style' => 'width: 160px;']
        ],
        [
            'attribute' => 'license',
            'headerOptions' => ['style' => 'width: 100px;']
        ],
        [
            'attribute' => 'status_id',
            'value' => function ($model) {
                return $model->statusName;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(\app\models\CaseStatus::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => 250],
            ],
            'filterInputOptions' => ['placeholder' => 'Choose State'],
            'format' => 'raw',
            'headerOptions' => ['style' => 'width: 260px;']
        ],
        [
            'attribute' => 'created_at',
            'format' => 'date',
            'headerOptions' => ['style' => 'width: 100px;']
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
    ]; ?>

    <?= GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => $columns,
        'toggleDataOptions' => [
            'all' => [
                'icon' => 'resize-full',
                'class' => 'btn btn-default',
                'label' => Yii::t('app', 'All'),
                'title' => Yii::t('app', 'Show all data')
            ],
            'page' => [
                'icon' => 'resize-small',
                'class' => 'btn btn-default',
                'label' => Yii::t('app', 'Page'),
                'title' => Yii::t('app', 'Show first page data')
            ],
        ],
        'toolbar' => [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reload Grid')]) .
                '{toggleData}' .
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
