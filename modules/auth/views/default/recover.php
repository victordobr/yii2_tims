<?php
/**
 * @var yii\web\View $this
 * @var app\modules\auth\models\forms\Login $model
 * @var yii\bootstrap\ActiveForm $form
 */

$this->title = Yii::t('app', 'Enter new password');

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

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= yii\helpers\Html::submitButton(Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php yii\bootstrap\ActiveForm::end(); ?>
    <?php endif; ?>

</div>

<?php
$this->registerJs("
if ( navigator.userAgent.toLowerCase().indexOf('firefox') > -1 ) {
    window.setTimeout(function(){
        $('input[type=\"password\"]').val('');
        $('#user-company_name').val('');
    }, 300);
}

 ");
?>
