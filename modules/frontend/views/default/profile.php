<?php
/**
 * @var \yii\web\View $this
 * @var \app\models\User $model
 * @var \app\models\forms\Password $passwordForm
 */
use \yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
use \yii\web\View;
use app\models\Question;

$this->title = \Yii::t('app', 'Update Profile');
?>
<div class="profile-update">

    <div class="white-background">
        <div class="profile-form">
            <div class="form-group">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'required-asterisk'],
                ]); ?>

                <?= $form->field($model, 'agency')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'pre_name')->dropDownList(
                    \app\models\User::getPreNameList()
                ); ?>

                <?= $form->field($model, 'first_name')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'middle_name')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'last_name')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'email')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'phone')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'state_id')->dropDownList(
                    \app\enums\States::listData()
                ); ?>

                <?= $form->field($model, 'zip_code')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'address')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

                <?= $form->field($model, 'question_id')->dropDownList(
                    Question::find()->select(['text', 'id'])->indexBy('id')->column(),
                    array('prompt' => ' - choose question - ')
                ); ?>


                <?= $form->field($model, 'question_answer')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control form-field-short',
                ]) ?>

            </div>

            <div class="form-group">

                <?= Html::buttonInput(\Yii::t('app', 'Change Password'), [
                    'class' => 'btn right-side bottom-space btn-info add-file-btn',
                    'id' => 'password-modal-open-button',
                ]); ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>


    </div>
</div>

<?= $this->render('partials/_changePasswordModal', [
    'model' => $passwordForm,
]); ?>

<?php $this->registerJs("
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
    });', View::POS_READY, 'pjaxScriptProfile'
); ?>
