<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\enums\States;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Owner */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="Owner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Owner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columns = [
        ['class'=>'kartik\grid\SerialColumn'],

        [
            'attribute' => 'id',
            'width' => '50px',
            'vAlign'=>'middle',
        ],
        [
            'attribute' => 'fullName',
            'width' => '200px',
            'vAlign'=>'middle',
        ],
        [
            'attribute' => 'license',
            'width' => '100px',
            'vAlign'=>'middle',
        ],
        [
            'attribute' => 'state_id',
//            'vAlign' => 'middle',
            'value' => function ($model) { return States::labelById($model->state_id);},

            // select2 has a problem (a large column width, and does not changing)
//            'filterType' => GridView::FILTER_SELECT2,
            'filter' => States::listData(),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],

            'filterInputOptions'=>['placeholder'=>'Any author'],
            'format'=>'raw',
            'headerOptions' => ['style' => 'width: 190px;'],
        ],
        [
            'attribute' => 'city',
            'width' => '150px',
            'vAlign'=>'middle',
        ],
        [
            'attribute' => 'zip_code',
            'width' => '100px',
            'vAlign'=>'middle',
        ],
        [
            'attribute' => 'email',
            'width' => '150px',
            'vAlign'=>'middle',
        ],
        [
            'attribute' => 'vehicleName',
            'width' => '150px',
            'vAlign'=>'middle',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
    ];

    $dynagrid = DynaGrid::begin([
        'columns'=>$columns,
        'theme'=>'panel-info',
        'showPersonalize'=>false,
        'allowThemeSetting' => false,
        'allowPageSetting' => false,
        'storage'=>'cookie',
        'gridOptions'=>[
            'dataProvider'=>$dataProvider,
            'filterModel'=>$searchModel,
//            'showPageSummary'=>true,
            'floatHeader'=>true,
            'pjax'=>true,
//            'panel'=>[
//                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Library</h3>',
//                'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
//                'after' => false
//            ],
//            'toolbar' =>  [
//                ['content'=>
//                    Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
//                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
//                ],
//                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
//                '{export}',
//            ]
        ],
        'options'=>['id'=>'dynagrid-1'] // a unique identifier is important
    ]);
    DynaGrid::end();
    ?>

</div>
