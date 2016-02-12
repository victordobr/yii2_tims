<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use \yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\icons\Icon;
?>

<div id="wrapper-record-print">

    <?php Pjax::begin([
        'id' => 'pjax-record-print',
        'timeout' => false,
        'enablePushState' => false,
        'formSelector' => '#form-record-search-filter'
    ]); ?>

    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary pull-right print-selected" disabled="disabled"><?= Yii::t('app', 'Print') ?></button>
        </div>
    </div>

    <?= GridView::widget([
        'id' => 'grid-record-print',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'kartik\grid\CheckboxColumn',
            ],
            [
                'label' => '#',
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'id',
            ],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'infraction_date',
                'format' => 'date',
            ],
            'license',
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'status_id',
            ],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'elapsedTime',
            ],
            [
                'class' => \kartik\grid\ActionColumn::className(),
                'template' => '{review}',
                'buttons' => [
                    'review' => function ($url, $model) {
                        return Html::a(
                            Icon::show('eye', ['class' => 'fa-lg']),
                            Url::to(['records/review', 'id' => $model->id]),
                            ['title' => Yii::t('app', 'Review'), 'data-pjax' => '0']
                        );
                    },
                ],
            ],
        ],
    ]);

    Pjax::end(); ?>

</div>