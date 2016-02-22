<?php

use yii\grid\GridView;
use app\enums\report\ReportType;

?>
<div class="col-md-4">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showHeader' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\DataColumn',
                'label' => ReportType::labelById($dataProvider->id),
                'format' => 'html',
                'value' => 'url',
            ],
        ],
        'layout'=>"\n{items}",
    ]); ?>
</div>
