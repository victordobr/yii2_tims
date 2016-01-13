<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\enums\States;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Owners */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Owners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owners-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Owners', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => Yii::t('app', 'Full Name'),
                'value' => function($model) { return $model->fullName;},
            ],
            'license',
            [
                'label' => Yii::t('app', 'State'),
                'value' => function($model) { return States::labelById($model->state_id);},
            ],
            'city',
            'zip_code',
            'email:email',
            [
                'label' => Yii::t('app', 'Vehicle'),
                'value' => function($model) { return $model->vehicle->makeModel;},
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],

        ],
    ]); ?>

</div>
