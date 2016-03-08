<?php

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\ActionColumn;
use app\enums\CaseStatus as Status;

$group = Status::listGroupsReport();
$hierarchy = Status::getHierarchyReport();
$header_columns[]= [
    'content' => $model->getAttributeLabel($model->group_by),
];
foreach ($hierarchy as $id => $items) {
    $header_columns[] = [
        'content' => $group[$id],
        'options' => [
            'colspan' => count($items),
        ]
    ];
}

$list_statuses = Status::listStatusesReport();
$statuses_ids = array_keys($list_statuses);
$columns[] = [
    'header' => '',
    'attribute' => $model->getGroupAttribute(),
    'width'=>'120px',
    'pageSummary' => Yii::t('app', 'Total'),
    'footer' => true,
];

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
    'layout'=>"\n{items}",
]); ?>

<?php Pjax::end(); ?>