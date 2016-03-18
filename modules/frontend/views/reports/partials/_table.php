<?php

use yii\grid\GridView;
use app\enums\report\ReportType;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showHeader' => true,
    'columns' => [
        [
            'class' => 'yii\grid\DataColumn',
            'label' => ReportType::labelById($dataProvider->id),
            'format' => 'html',
            'value' => 'url',
        ],
    ],
    'layout'=>"\n{items}",
]); ?>