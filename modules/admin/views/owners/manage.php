<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\enums\States;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\Owner */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Owners';
?>
<div class="Owner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Owner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fullName',
            'license',
            'stateName',
            'city',
            'zip_code',
            'email:email',
            'vehicleName',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],

        ],
    ]); ?>

</div>
