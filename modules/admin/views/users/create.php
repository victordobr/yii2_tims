<?php
/**
 * @var yii\web\View $this
 * @var app\models\User $model
 */

$this->title = \Yii::t('app', 'Create User');
?>
<div class="user-create">

    <h1><?= yii\helpers\Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
