<?php

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\ActionColumn;
use app\enums\CaseStatus as Status;

foreach($headerGroups as $key => $value)
    $header_columns[] = [
        'content' => $value['content'],
        'options' => [
            'colspan' => $value['colspan'],
        ]
];

$columns[] = [
    'header' => '',
    'attribute' => $groupAttribute,
    'width'=>'120px',
    'pageSummary' => Yii::t('app', 'Total'),
    'footer' => true,
];

foreach ($statuses as $id => $value) {
    $columns[] = [
        'header' => '<div><span>' . $value . '</span></div>',
        'attribute' => 'status_' . $id,
        'headerOptions' => [
            'class' => 'rotated-text',
        ],
        'pageSummary' => true,
        'footer' => true,
    ];
}

?>

<?php Pjax::begin([
    'id' => 'pjax-frontend-search',
    'timeout' => false,
    'enablePushState' => false,
    'formSelector' => '#form-record-reports-filter',
    'options' => ['class' => 'wrapper-grid-view',]
]); ?>

    <?=$this->params['date_range']?>
    <?=(isset($this->params['group_by'])) ? $this->params['group_by'] : ''?>

    <?= GridView::widget([
        'id' => 'record-grid-summary-report',
        'dataProvider' => $dataProvider,
        'columns' => $columns,
        'beforeHeader' => [
            [
                'columns' => $header_columns,
            ]
        ],
        'headerRowOptions'=>[
    //            'class' => 'kartik-sheet-style',
    //            'align' => 'center',
        ],
        'showPageSummary' => true,
        'resizableColumns' => false,
        'responsive' => false,
        'condensed' => false,
        'persistResize' => false,
        'layout'=>"\n{items}\n{pager}",
    ]); ?>

<?php Pjax::end(); ?>