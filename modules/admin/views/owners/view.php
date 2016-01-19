<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Owner */

$this->title = $model->id;

?>
<div class="Owner-view">

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
            'first_name',
            'middle_name',
            'last_name',
            'address_1:ntext',
            'address_2:ntext',
            'city',
            'state_id',
            'license',
            'zip_code',
            'email:email',
            'phone',
            'vehicle_id',
            'vehicle_year',
            'vehicle_color_id',
            'created_at',
        ],
    ]) ?>

</div>
