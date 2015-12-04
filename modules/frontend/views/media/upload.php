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
use \yii\helpers\Html;
use \yii\web\View;
use \dosamigos\fileupload\FileUpload;
use yii\bootstrap\ActiveForm;

$this->title = 'Create Evidence';
$this->params['breadcrumbs'][] = ['label' => 'Evidences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="evidence-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="evidence-form">

        <?php $form = ActiveForm::begin([
            'id' => 'evidence-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
        ]); ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'attribute' => 'video_lpr',
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'attribute' => 'video_overview_camera',
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'attribute' => 'image_lpr',
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $this->render('partials/_chunkInput', [
            'model' => $model,
            'attribute' => 'image_overview_camera',
            'uploadUrl' => $uploadUrl,
            'acceptMimeTypes' => $acceptMimeTypes,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
            'handleUrl' => $handleUrl,
        ]) ?>

        <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'state_id')->textInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>