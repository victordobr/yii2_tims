<?php
use app\widgets\base\ActiveForm;

/**
 * @var yii\web\View                        $this
 * @var app\modules\auth\models\forms\Login $model
 * @var yii\bootstrap\ActiveForm            $form
 */

$this->title = Yii::t('app', 'Login');
?>

<div class="site-login">

    <?php if (Yii::$app->session->hasFlash('successActivation')): ?>
        <?= Yii::$app->session->getFlash('successActivation'); ?>
    <?php endif; ?>


        <div class="col-md-offset-7 col-md-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'title' => Yii::t('app', 'Welcome back!'),
                'panel_class' => 'panel-form-login',
//                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
//                    'template' => "<div class=\"col-md-4\">{label}\n</div><div class=\"col-md-8\">{input}\n{error}\n</div>",
//                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('app', 'email')])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'password')])->label(false) ?>

            <div class="form-group form-actions">
                <?= yii\helpers\Html::a(Yii::t('app', 'Forgot password?'), ['forgot'], ['class' => 'btn btn-link']); ?>
                <?= yii\helpers\Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

</div>
