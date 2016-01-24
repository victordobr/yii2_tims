<?php

use yii\helpers\Html;
use app\enums\States;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Owner */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Owners Manager');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Owner-index">

    <?php $columns = [
        [
            'label' => '#',
            'attribute' => 'id',
            'headerOptions' => ['style' => 'width: 100px;']
        ],
        'fullName',
        'license',
        [
            'attribute' => 'state_id',
            'value' => function ($model) {
                return States::labelById($model->state_id);
            },

            // select2 has a problem (a large column width, and does not changing)
            'filterType' => GridView::FILTER_SELECT2,
//            'filterType' => yii\helpers\Html::dropDownList(),
            'filter' => States::listData(),
            'width' => '8%',
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => 150],
            ],

            'filterInputOptions' => ['placeholder' => 'Choose State'],
//            'format'=>'raw',
            'headerOptions' => ['style' => 'width: 190px;'],
        ],
        'city',
        'zip_code',
        'email',
        'vehicleName',
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}'
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
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['role' => 'modal-remote', 'title' => Yii::t('app', 'Create Owner'), 'class' => 'btn btn-default']) .
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
