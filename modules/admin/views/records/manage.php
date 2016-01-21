<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\enums\States;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Record */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manager of records');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-manage">

    <?php $columns = [
        ['class'=>'kartik\grid\SerialColumn',
            'contentOptions' => ['class'=>'kartik-sheet-style'],
            'width'=>'36px',
            'header'=>'',
            'headerOptions' => ['class'=>'kartik-sheet-style']
        ],
        'id',
        'infraction_date',
        [
            'attribute' => 'state_id',
            'value' => function ($model) {
                return States::labelById($model->state_id);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => States::listData(),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any author'],
            'format'=>'raw',
        ],
        'license',
        [
            'attribute' => 'status_id',
            'value' => function ($model) {
                return $model->statusName;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(\app\models\CaseStatus::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Any author'],
            'format' => 'raw'
        ],
        'created_at',
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
    ];?>

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
