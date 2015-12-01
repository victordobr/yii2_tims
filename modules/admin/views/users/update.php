<?php
/**
 * @var yii\web\View $this
 * @var app\models\User $model
 */

//$this->title = \Yii::t('app', 'UPDATE_USER_TITLE',['id' => $model->id, 'fullName' => $model->getFullName()]) ;
$this->title = 'Update User #' . $model->id . ': ' . $model->getFullName();
?>
<div class="user-update">

    <h1><?= yii\helpers\Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

    <div class="user-details">
        <div class="well well-sm">
            <p><strong><?= $model->getAttributeLabel('logins_count')?>: </strong><?= $model->logins_count; ?></p>
            <p><strong><?= $model->getAttributeLabel('created_at')?>: </strong><?= \Yii::$app->formatter->asDatetime($model->created_at); ?></p>
            <p><strong><?= $model->getAttributeLabel('last_login_at')?>: </strong><?= \Yii::$app->formatter->asDatetime($model->last_login_at); ?></p>
        </div>
    </div>
</div>
