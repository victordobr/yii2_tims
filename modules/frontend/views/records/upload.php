<?php
/**
 * @var $this View
 * @var string $uploadUrl
 * @var string $handleUrl
 * @var string $acceptMimeTypes
 * @var int $maxFileSize
 * @var int $maxChunkSize
 * @var mixed $dropZone
 * @author Alex Makhorin
 */
use yii\helpers\Html;
use \yii\web\View;
use yii\bootstrap\ActiveForm;
use app\enums\EvidenceFileType;
use kartik\date\DatePicker;
use app\enums\States;
use yii\widgets\MaskedInput;

$this->title = 'Upload Evidence';
$this->params['breadcrumbs'][] = ['label' => 'Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="Record-create">

    <div class="Record-form">

        <?php $form = ActiveForm::begin([
            'id' => 'record-form',
            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-lg-3\">{label}</div>\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-5\">{error}</div><div class=\"hidden hint-block\">{hint}</div>",
                'labelOptions' => ['class' => 'control-label right'],
            ],
        ]); ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'form' => $form,
            'attribute' => 'videoLpr',
            'type' => EvidenceFileType::TYPE_VIDEO_LPR,
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'form' => $form,
            'attribute' => 'videoOverviewCamera',
            'type' => EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA,
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'form' => $form,
            'attribute' => 'imageLpr',
            'type' => EvidenceFileType::TYPE_IMAGE_LPR,
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'form' => $form,
            'attribute' => 'imageOverviewCamera',
            'type' => EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA,
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?php echo $form->field($model, 'infraction_date')->widget(DatePicker::classname(), [
            'layout' => '{input}{picker}',
            'options' => [
                'placeholder' => 'Enter infraction date ...',
            ],
            'pluginOptions' => [
                'format' => Yii::$app->params['date.view.format'],
            ]
        ]);
        ?>

        <?= $form->field($model, 'lat')->widget(MaskedInput::classname(), [
            'mask' =>  '9[9[9]]\º 9[9[9]]\' 9[9].9[9[9]]\" a',
        ])->hint('If the current value less than mask value, please use space key(on the keyboard) in order to move cursor to the next sub field! Latitude example 49º 59\' 36.6" N') ?>
        <?= $form->field($model, 'lng')->widget(MaskedInput::classname(), [
            'mask' =>  '9[9[9]]\º 9[9[9]]\' 9[9].9[9[9]]\" a',
        ])->hint('If the current value less than mask value, please use space key(on the keyboard) in order to move cursor to the next sub field! Longitude example 36º 13\' 49.378" E') ?>

        <?= $form->field($model, 'state_id')->dropDownList(States::listData(), array('prompt' => ' - choose state - ')) ?>
        <?= $form->field($model, 'license')->textInput(['maxlength' => true])->hint('Please enter driver licence.') ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>