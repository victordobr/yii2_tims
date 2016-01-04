<?php
use \yii\bootstrap\Modal;
use \yii\helpers\Html;
use \yii\widgets\Pjax;
use \yii\bootstrap\ActiveForm;
use \yii\helpers\Url;

/**
 * @var ActiveForm $form
 * @var \app\models\forms\Password $model
 */
?>
<?php Modal::begin([
    'header'        => \Yii::t('app', 'Edit Password'),
    'headerOptions' => ['id' => 'modalHeaderEdit'],
    'id'            => 'modal-change-password',
    'size'          => 'modal-lg',
    'closeButton'   => [
        'tag'   => 'button',
        'label' => '×',
    ],
    'footer'        => Html::submitButton( \Yii::t('app', 'Save'), [
        'class' => 'btn btn-success',
        'id'    => 'save-changes',
        'form'  => 'change-password-form',
    ]),
]); ?>

    <?php Pjax::begin([
        'id'                 => 'user-profile-change-password',
        'timeout'            => false,
        'enablePushState'    => false,
        'enableReplaceState' => false,
    ]); ?>

        <?php $form = ActiveForm::begin([
            'options' => [
                'id'        => 'change-password-form',
                'data-pjax' => true,
                'method'    => 'post',
                'class'     => 'required-asterisk',
            ],
            'action'  => Url::to(['change-password'])
        ]); ?>

        <?= $form->field($model, 'old')->passwordInput([
            'maxlength' => true,
            'class'     => 'form-control form-field-short',
        ]) ?>

        <?= $form->field($model, 'new')->passwordInput([
            'maxlength' => true,
            'class'     => 'form-control form-field-short',
        ]) ?>
        <?= $form->field($model, 'repeat')->passwordInput([
            'maxlength' => true,
            'class'     => 'form-control form-field-short',
        ]) ?>

        <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

<?php Modal::end(); ?>

