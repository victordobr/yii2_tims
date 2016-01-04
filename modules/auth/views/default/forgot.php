<?php
/**
 * @var yii\web\View $this
 * @var app\modules\auth\models\forms\Login $model
 * @var yii\bootstrap\ActiveForm $form
 */

$this->title = Yii::t('app', 'Password recovery');

?>
<div class="site-login">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <?= Yii::$app->session->getFlash('success'); ?>
        <?= yii\helpers\Html::a(Yii::t('app', 'Home Page'), ['/'], ['class'=>'btn btn-primary']); ?>
    <?php else: ?>

        <h1><?= yii\helpers\Html::encode($this->title) ?></h1>

        <?php $form = yii\bootstrap\ActiveForm::begin([
            'id' => 'forgot-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-4\">{input}\n{hint}</div>\n<div class=\"col-lg-4\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'email')->hint(Yii::t('app', 'Enter your email. We\'ll send further instructions to recover your password')) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= yii\helpers\Html::submitButton(Yii::t('app', 'Send'),
                    ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php yii\bootstrap\ActiveForm::end(); ?>
    <?php endif; ?>

</div>
