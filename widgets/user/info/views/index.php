<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>

<div class="panel panel-default panel-user-info">
    <div class="panel-heading">
        <ul id="clock">
            <li id="Date"></li>
            <li id="hours">00</li>
            <li id="point">:</li>
            <li id="min">00</li>
            <li id="point">:</li>
            <li id="sec">00</li>
        </ul>
    </div>

    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $user,
            'options' => ['class' => 'table'],
            'attributes' => [
                [
                    'label' => Yii::t('app', 'Logged as User:'),
                    'attribute' => 'pre_name'
                ],
                [
                    'label' => Yii::t('app', 'Logged in Since:'),
                    'format' => 'datetime',
                    'attribute' => 'last_login_at'
                ],
            ],
        ]) ?>
        <div class="control-group">
            <?= Html::a('User profile', Url::to('/frontend/default/profile'))?>
            <?= Html::a('Logout', Url::to('/logout'), ['class' => 'pull-right'])?>
        </div>
    </div>
</div>