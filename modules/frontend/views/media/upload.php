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
use app\enums\EvidenceFileType;
use kartik\date\DatePicker;
use app\enums\States;

$this->title = 'Create Evidence';
$this->params['breadcrumbs'][] = ['label' => 'Evidences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="evidence-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="evidence-form">

        <?php $form = ActiveForm::begin([
            'id' => 'evidence-form',
            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
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
                'format' => Yii::$app->params['date.view.format.column'],
            ]
        ]);
        ?>


        <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'state_id')->dropDownList(States::listData(), array('prompt' => ' - choose state - ')) ?>
        <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>