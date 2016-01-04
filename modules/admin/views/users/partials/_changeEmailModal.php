<?php
use \yii\bootstrap\Modal;
use \yii\widgets\Pjax;
use \yii\bootstrap\ActiveForm;
use \yii\helpers\Url;
use \yii\helpers\Html;

/**
 * @var ActiveForm $form
 * @var \app\models\User $model
 */
?>
<?php Modal::begin([
    'header'        => \Yii::t('app', 'Edit Email'),
    'headerOptions' => ['id' => 'modalHeaderEdit'],
    'id'            => 'modal-change-email',
    'size'          => 'modal-lg',
    'closeButton'   => [
        'tag'   => 'button',
        'label' => '×',
    ],
    'footer'        => Html::submitButton( \Yii::t('app', 'Save'), [
        'class' => 'btn btn-success',
        'id'    => 'save-changes',
        'form'  => 'change-email-form',
    ]),
]); ?>

    <?php Pjax::begin([
        'id'                 => 'user-profile-change-email',
        'timeout'            => false,
        'enablePushState'    => false,
        'enableReplaceState' => false,
    ]); ?>

        <?php $form = ActiveForm::begin([
            'options' => [
                'id'        => 'change-email-form',
                'data-pjax' => true,
                'method'    => 'post',
                'class'     => 'required-asterisk',
            ],
            'action'  => Url::to(['change-email'])
        ]); ?>

        <p><strong class="attention"><?= \Yii::t('app', 'ATTENTION'); ?>:</strong> <?= \Yii::t('app', 'USER_CHANGE_EMAIL_WARNING'); ?></p>

        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'class'     => 'form-control form-field-short',
            'email' => $model->email,
            'id' => 'change-email-field'
        ]) ?>

        <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

<?php Modal::end(); ?>

