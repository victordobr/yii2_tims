<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $provider
 */

use yii\helpers\Url;
use \yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use app\widgets\base\GridView;
use kartik\grid\SerialColumn;
use kartik\grid\ActionColumn;
?>
<?php if (Yii::$app->request->referrer): ?>
    <div class="row">
        <?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer , ['class' => 'btn btn-default', 'role' => 'button']) ?>
    </div>
<?php endif; ?>
<div class="user-index">

    <div class="white-background">

        <?php Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
            'formSelector' => '#form-record-reports-filter',
            'options' => ['class' => 'wrapper-grid-view',]
        ]); ?>

        <?= GridView::widget([
            'id' => 'record-grid-report',
            'dataProvider' => $provider,
            'columns' => [
                [
                    'class' => SerialColumn::className(),
                ],
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'infraction_date',
                    'format' => 'date',
                ],
                'id',
                'license',
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'created_at',
                    'format' => 'date',
                ],
                'author',
                [
                    'hAlign' => GridView::ALIGN_CENTER,
                    'attribute' => 'elapsedTime',
                ],
                [
                    'header' => Html::a(Icon::show('refresh', ['class' => 'fa-lg']), '#', ['class' => 'grid-view-refresh', 'title' => Yii::t('app', 'refresh grid')]),
                    'class' => ActionColumn::className(),
                    'template'=>'{view}',
                    'buttons'=>[
                        'view' => function ($url, $model) {
                            return Html::a(
                                Icon::show('eye', ['class' => 'fa-lg']),
                                '/review/' . $model->id,
                                ['title' => Yii::t('app', 'Review'), 'data-pjax' => '0']
                            );
                        },
                    ],
                ],
            ],
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['role' => 'modal-remote', 'title' => Yii::t('app', 'Create Owner'), 'class' => 'btn btn-default']) .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reload Grid')]) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
        ]);
        yii\widgets\Pjax::end();
        ?>
    </div>

</div>
