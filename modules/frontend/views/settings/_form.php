<?php
/**
 * @link http://phe.me
 * @copyright Copyright (c) 2014 Pheme
 * @license MIT http://opensource.org/licenses/MIT
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pheme\settings\Module;

/**
 * @var yii\web\View $this
 * @var pheme\settings\models\Setting $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin([
        'id' => 'setting-form',
        'enableAjaxValidation' => true,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-3\">{label}</div>\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-5\">{error}</div><div class=\"hidden hint-block\">{hint}</div>",
            'labelOptions' => ['class' => 'control-label right'],
        ],
    ]); ?>

    <?= $form->field($model, 'section')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->checkbox(['value' => 1]) ?>

    <?=
    $form->field($model, 'type')->dropDownList(
        [
            'string' => 'string',
            'integer' => 'integer',
            'boolean' => 'boolean',
            'float' => 'float',
            'array' => 'array',
            'object' => 'object',
            'null' => 'null'
        ]
    )->hint(\Yii::t('app', 'Change at your own risk')) ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-8">
            <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), [
                    'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-success',
                ]
            ) ?>

            <?php if (!$model->isNewRecord) : ?>
                <?= Html::a( \Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                        ],
                    ]
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
