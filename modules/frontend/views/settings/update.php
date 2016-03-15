<?php

use app\modules\admin\models\Setting;

$this->title = \Yii::t(
        'app',
        'Update {modelClass}: ',
        [
            'modelClass' => \Yii::t('app', 'Setting'),
        ]
    ) . ' ' . $model->section. '.' . $model->key;

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');

?>
<div class="setting-update">

    <?= $this->render('_form',['model' => $model]) ?>

</div>
