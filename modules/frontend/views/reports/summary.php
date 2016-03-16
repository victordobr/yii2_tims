<?php

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\ActionColumn;
use app\enums\CaseStatus as Status;

$header_columns = array_map(function($content, $colspan) {
        return [
            'content' => $content,
            'options' => [
                'colspan' => count($colspan),
            ]
        ];
    }, $headerGroup['content'], $headerGroup['colspan']);

$columns[] = [
    'header' => '',
    'attribute' => $groupTableAttribute,
    'width'=>'120px',
    'pageSummary' => Yii::t('app', 'Total'),
    'footer' => true,
];

$list_statuses = Status::listStatusesReport();
$statuses_ids = array_keys($list_statuses);
foreach ($statuses_ids as $id) {
    $columns[] = [
        'header' => '<div><span>' . $list_statuses[$id] . '</span></div>',
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