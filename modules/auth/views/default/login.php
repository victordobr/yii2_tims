<?php
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\auth\models\forms\Login $model
 * @var yii\bootstrap\ActiveForm $form
 */

$this->title = Yii::t('app', 'Login');
?>
<div class="site-login">
    <h1><?= yii\helpers\Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('successActivation')): ?>
        <?= Yii::$app->session->getFlash('successActivation'); ?>
    <?php endif; ?>

    <p><?= Yii::t('app', 'Please fill out the following fields to login') ?>:</p>

    <?php $form = ActiveForm::begin([
        'id'          => 'login-form',
        'options'     => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>


    <?= $form->field($model, 'rememberMe')->checkbox(); ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= yii\helpers\Html::submitButton(Yii::t('app', 'Login'),
                ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

            <?php echo yii\helpers\Html::a(Yii::t('app', 'Forgot password?'), ['forgot'], ['class' => 'btn btn-link']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
