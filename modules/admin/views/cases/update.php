<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PoliceCase */

$this->title = 'Update Case: ' . ' ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Police Cases', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="police-case-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
