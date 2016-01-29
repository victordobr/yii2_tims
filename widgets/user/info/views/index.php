<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div id="Date"></div>
        <ul id="clock">
            <li id="hours"> </li>
            <li id="point">:</li>
            <li id="min"> </li>
            <li id="point">:</li>
            <li id="sec"> </li>
        </ul>
    </div>

    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $user,
            'options' => ['class' => 'table'],
            'attributes' => [
//                [
//                    'label' => Yii::t('app', 'Date case opened'),
//                    'format' => 'raw',
//                    'value' => $formatter->asDatetime($model->open_date)
//                ],
                [
                    'label' => Yii::t('app', 'Logged as User'),
                    'attribute' => 'pre_name'
                ],
                [
                    'label' => Yii::t('app', 'Logged in Since'),
                    'format' => 'datetime',
                    'attribute' => 'last_login_at'
                ],

//                [
//                    'label' => Yii::t('app', 'Vehicle TAG'),
//                    'attribute' => 'license',
//                ],
//                [
//                    'label' => Yii::t('app', 'Date of alleged infraction'),
//                    'format' => 'raw',
//                    'value' => sprintf('%s (%s)', $formatter->asDatetime($model->infraction_date, 'php:d-m-Y H:i:s'), $formatter->asElapsedTime($model->infraction_date))
//                ],
//                [
//                    'label' => Yii::t('app', 'Status'),
//                    'attribute' => 'status.name',
//                ],
            ],
        ]) ?>
        <div class="control-group">
            <?= Html::a('User profile', Url::to('/frontend/default/profile'))?>
            <?= Html::a('Logout', Url::to('/logout'), ['class' => 'pull-right'])?>
        </div>
    </div>
</div>