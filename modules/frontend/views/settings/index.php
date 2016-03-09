<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\SerialColumn;
use kartik\grid\ActionColumn;

?>

<?php ?>
<div class="settings-index">

    <div class="white-background col-md-12">

        <p>
            <?= Html::a(Yii::t('app', 'Create New Setting'), ['create'], ['class' => 'btn btn-default', 'role' => 'button']) ?>
        </p>
        <?php Pjax::begin([
            'id' => 'pjax-settings-index',
            'timeout' => false,
            'enablePushState' => false,
            'options' => ['class' => 'wrapper-settings-grid',]
        ]); ?>

        <?= GridView::widget([
            'id' => 'settings-grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => SerialColumn::className(),
                ],
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'vAlign' => GridView::ALIGN_MIDDLE,
                    'attribute' => 'section',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $sectionsList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true, 'width' => 200],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Choose section', 'multiple' => true],
                    'format' => 'raw',
                    'group' => true,
                ],
                'key',
                'value:ntext',
                [
                    'class' => '\pheme\grid\ToggleColumn',
                    'attribute' => 'active',
                    'filter' => [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')],
                ],
                [
                    'attribute' => 'created',
                    'format' => ['date', 'php:d/m/y H:i'],
                    'mergeHeader' => true,
                    'width' => 200
                ],
                [
                    'attribute' => 'modified',
                    'format' => ['date', 'php:d/m/Y H:i'],
                    'mergeHeader' => true,
                    'width' => 200
                ],
                [
                    'header' => Html::a(Icon::show('refresh', ['class' => 'fa-lg']), '#', ['class' => 'grid-view-refresh', 'title' => Yii::t('app', 'refresh grid')]),
                    'class' => ActionColumn::className(),
                    'template'=>'{view}{edit}',
                    'buttons'=>[
                        'view' => function ($url, $model) {
                            return Html::a(
                                Icon::show('pencil', ['class' => 'fa-lg']),
                                Url::to(['update', 'id' => $model->id]),
                                ['title' => Yii::t('app', 'View'), 'data-pjax' => '0']
                            );
                        },
                    ],
                ]
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
