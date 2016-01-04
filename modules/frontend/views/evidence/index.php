<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\frontend\models\search\Evidence */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evidences';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evidence-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'case_id',
            'user_id',
//            'video_lpr',
//            'video_overview_camera',
            // 'image_lpr',
            // 'image_overview_camera',
             'license',
             'state_id',
             'created_at:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
