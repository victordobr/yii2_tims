<?php
/**
 * @var yii\web\View $this
 * @var app\models\User $model
 * @version 1.0
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */

$this->title = \Yii::t('app', 'Create User');
?>
<div class="user-create">

    <h1><?= yii\helpers\Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
