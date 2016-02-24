<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $provider
 */

use yii\widgets\Pjax;
use yii\widgets\ListView;

?>

<div class="wrapper-preview">

    <div class="col-lg-8 col-lg-offset-2">

        <div class="row text-right noprint">
            <button class="btn btn-primary btn-print"><?= Yii::t('app', 'Print'); ?></button>
        </div>

        <?= ListView::widget([
            'id' => 'list-print-preview',
            'dataProvider' => $provider,
            'itemView' => 'preview/record',
            'summary' => '',
        ]); ?>

    </div>
</div>