<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\widgets\Pjax;
use yii\widgets\ListView;

$this->title = \Yii::t('app', 'Print preview');
$clearLabel = \Yii::t('app', 'Clear Filters');
?>

<div class="wrapper-preview">

    <div class="col-lg-8 col-lg-offset-2">

        <div class="row noprint">
            <button class="btn btn-primary pull-right btn-print"><?= Yii::t('app', 'Print'); ?></button>
        </div>

        <?php
        Pjax::begin([
            'id' => 'pjax-print-preview',
            'timeout' => false,
            'enablePushState' => false,
        ]);
        ?>
        <?= ListView::widget([
            'id' => 'list-print-preview',
            'dataProvider' => $dataProvider,
            'itemView' => 'preview/record',
            'summary'=>'',
        ]); ?>

    </div>
</div>