<?php
/**
 * @var \yii\web\View $this
 * @var \app\models\User $model
 * @var \app\models\forms\Password $passwordForm
 * @var int $racksPaid
 * @var int $allRacks
 * @var float|int|string $availSpace
 * @var float|int|string $usedSpace
 * @var float|int|string $freeSpace
 */
use \yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
use \yii\web\View;
$this->title = \Yii::t('app', 'Update Profile');
?>
    <div class="profile-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="profile-form">
            <div class="form-group">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'required-asterisk'],
                ]); ?>

                <?= $form->field($model, 'first_name')->textInput([
                    'maxlength' => true,
                    'class'  => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'last_name')->textInput([
                    'maxlength' => true,
                    'class'  => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'phone')->textInput([
                    'maxlength' => true,
                    'class'  => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'company_name')->textInput([
                    'maxlength' => true,
                    'class'  => 'form-control form-field-short',
                ]) ?>

            </div>

            <div class="form-group">
                <?= Html::submitButton( \Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

        <div class="profile-details">
            <div class="well well-sm">
                <p><strong><?= \Yii::t('app', 'Number of racks') ?>: </strong><?= $allRacks; ?></p>
                <p><strong><?= \Yii::t('app', 'Used Space') ?>: </strong><?= number_format($usedSpace, 2); ?> Mb</p>
            </div>

            <?= Html::buttonInput( \Yii::t('app', 'Change Email'),  [
                'class'   => 'btn right-side left-space bottom-space btn-info add-file-btn',
                'id' => 'email-modal-open-button',
            ]); ?>

            <?= Html::buttonInput( \Yii::t('app', 'Change Password'),  [
                'class'   => 'btn right-side bottom-space btn-info add-file-btn',
                'id' => 'password-modal-open-button',
            ]); ?>
        </div>
    </div>

<?= $this->render('partials/_changeEmailModal', [
    'model' => $model,
]); ?>

<?= $this->render('partials/_changePasswordModal', [
    'model' => $passwordForm,
]); ?>

<?php $this->registerJs("
    $('#email-modal-open-button').on('click', function(e) {
        $('#modal-change-email').modal('show');
    });

    $('#password-modal-open-button').on('click', function(e) {
        $('#modal-change-password').modal('show');
    });
", View::POS_READY, 'modalScripts'); ?>

<?php $this->registerJs(
    '$("document").ready(function(){
        $("#user-profile-change-password").on("pjax:start", function() {
            showLoading();
        });

        $("#user-profile-change-password").on("pjax:success", function(a,b,c) {
            hideLoading();
        });

        $("#user-profile-change-email").on("pjax:start", function() {
            if($("#change-email-field").attr("email") == $("#change-email-field").val()) {
                $("#modal-change-email").modal("hide");
                return false;
            }
            showLoading();
        });

        $("#user-profile-change-email").on("pjax:success", function(a,b,c) {
            if($(c).find(".help-block-error")) {
                hideLoading();
            }
        });
    });', View::POS_READY, 'pjaxScriptProfile'
); ?>
