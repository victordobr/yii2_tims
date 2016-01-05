<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PoliceCase */

$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Police Cases', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="police-case-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status_id',
            'created_at',
            'open_date',
            'infraction_date',
            'officer_date',
            'mailed_date',
            'officer_pin',
            'officer_id',
        ],
    ]) ?>

</div>
