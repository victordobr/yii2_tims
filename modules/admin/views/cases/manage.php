<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Case */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cases Listing';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="police-case-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('partials/_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Police Case', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status_id',
            'created_at',
            'open_date',
            // 'officer_date',
            // 'mailed_date',
            // 'officer_pin',
            // 'officer_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
