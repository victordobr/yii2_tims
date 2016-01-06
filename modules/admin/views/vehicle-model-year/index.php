<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\VehicleModelYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicle Model Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-model-year-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vehicle Model Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'year',
            'make',
            'model',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
