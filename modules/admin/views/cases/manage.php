<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Case */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cases Listing';

?>
<div class="police-case-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('partials/_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'evidence.infraction_date',
            'caseStatus.StatusName',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
