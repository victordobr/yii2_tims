<?php
/**
 * @var yii\web\View $this
 * @var app\modules\auth\models\forms\Login $model
 * @var yii\bootstrap\ActiveForm $form
 */

$this->title = Yii::t('app', 'Account activation');

?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>

<div class="site-login">
    <?php if (Yii::$app->session->hasFlash('successActivation')): ?>
        <?= Yii::$app->session->getFlash('successActivation'); ?>
        <?= yii\helpers\Html::a(Yii::t('app', 'Home Page'), ['/'], ['class'=>'btn btn-primary']); ?>
    <?php endif; ?>

</div>