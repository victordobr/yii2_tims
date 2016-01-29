<?php
/**
 * @var yii\web\View $this
 * @var app\modules\auth\models\forms\Answer $model
 * @var yii\bootstrap\ActiveForm $form
 */

$this->title = Yii::t('app', 'Enter answer');

?>
<div class="site-login">
        <?= Yii::$app->session->getFlash('danger'); ?>

        <h1><?= yii\helpers\Html::encode($this->title) ?></h1>

        <?php $form = yii\bootstrap\ActiveForm::begin([
            'id' => 'forgot-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-4\">{input}\n{hint}</div>\n<div class=\"col-lg-4\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <h3><?= $questions ?></h3>

        <?= $form->field($model, 'answer')->textInput([
            'maxlength' => true,
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= yii\helpers\Html::submitButton(Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php yii\bootstrap\ActiveForm::end(); ?>

</div>