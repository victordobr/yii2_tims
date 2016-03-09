<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $provider
 */

use app\widgets\base\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use kartik\grid\CheckboxColumn;
use kartik\grid\SerialColumn;
use \app\components\Record;

?>

<div id="wrapper-record-print">

    <?php Pjax::begin([
        'id' => 'pjax-record-print',
        'timeout' => false,
        'enablePushState' => false,
        'formSelector' => '#form-record-search-filter-basic, #form-record-search-filter-advanced',
        'options' => ['class' => 'wrapper-grid-view',]
    ]); ?>

    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary pull-right print-selected" disabled="disabled"><?= Yii::t('app', 'Print') ?></button>
        </div>
    </div>

    <?= GridView::widget([
        'id' => 'grid-record-print',
        'dataProvider' => $provider,
        'columns' => [
            ['class' => CheckboxColumn::className(),],
            ['class' => SerialColumn::className(),],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'infraction_date',
                'format' => 'date',
            ],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'id',
            ],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'license',
            ],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'status_id',
            ],
            [
                'hAlign' => GridView::ALIGN_CENTER,
                'attribute' => 'elapsedTime',
            ],
            [
                'header' => Html::a(Icon::show('refresh', ['class' => 'fa-lg']), '#', ['class' => 'grid-view-refresh', 'title' => Yii::t('app', 'refresh grid')]),
                'class' => \kartik\grid\ActionColumn::className(),
                'template' => '{review}',
                'buttons' => [
                    'review' => function ($url, $model) {
                        return Html::a(
                            Icon::show('eye', ['class' => 'fa-lg']),
                            Url::to(['PrintView', 'id' => $model->id]),
                            ['title' => Yii::t('app', 'Review'), 'data-pjax' => '0']
                        );
                    },
                ],
            ],
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            return ['class' => Record::getPrintRowClass($model->created_at)];
        },
    ]);

    Pjax::end(); ?>

</div>