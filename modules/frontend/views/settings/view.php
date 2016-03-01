<?php

use yii\widgets\DetailView;

$this->title = $model->section. '.' . $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-view">

    <?=
    DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                'id',
                'type',
                'section',
                'active:boolean',
                'key',
                'value:ntext',
                'created:datetime',
                'modified:datetime',
            ],
        ]
    ) ?>

</div>
