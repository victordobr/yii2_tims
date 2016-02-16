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
use yii\widgets\MaskedInput;

$this->title = 'Verify Evidence';
$this->params['breadcrumbs'][] = ['label' => 'Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="record-media">
        <?php if ($model->imageOverviewCamera): ?>
            <?= app\widgets\mediaPopup\MediaPopup::widget([
                'url' => $model->imageOverviewCamera->url,
                'type' => $model->imageOverviewCamera->file_type,
                'title' => $model->getAttributeLabel('imageOverviewCamera'),
                'mime' => $model->imageOverviewCamera->mime_type,
            ]); ?>
        <?php endif; ?>

        <?php if ($model->imageLpr): ?>
            <?= app\widgets\mediaPopup\MediaPopup::widget([
                'url' => $model->imageLpr->url,
                'type' => $model->imageLpr->file_type,
                'title' => $model->getAttributeLabel('imageLpr'),
                'mime' => $model->imageLpr->mime_type,
            ]); ?>
        <?php endif; ?>

        <?php if ($model->videoLpr): ?>
            <?= app\widgets\mediaPopup\MediaPopup::widget([
                'url' => $model->videoLpr->url,
                'type' => $model->videoLpr->file_type,
                'title' => $model->getAttributeLabel('videoLpr'),
                'mime' => $model->videoLpr->mime_type,
            ]); ?>
        <?php endif; ?>

        <?php if ($model->videoOverviewCamera): ?>
            <?= app\widgets\mediaPopup\MediaPopup::widget([
                'url' => $model->videoOverviewCamera->url,
                'type' => $model->videoOverviewCamera->file_type,
                'title' => $model->getAttributeLabel('videoOverviewCamera'),
                'mime' => $model->videoOverviewCamera->mime_type,
            ]); ?>
        <?php endif; ?>

        <?php if ($model->location->lat_dd && $model->location->lng_dd): ?>
            <?= app\widgets\mapPopup\MapPopup::widget([
                'latitude' => $model->location->lat_dd,
                'longitude' => $model->location->lng_dd,
            ]); ?>

        <?php endif; ?>

        <div class="record-form">





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

<!--            --><?php //var_dump($model->infraction_date); die;?>

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

        <?= $form->field($location, 'lat_ddm')->widget(MaskedInput::classname(), [
            'mask' =>  '9[9[9]].9[9[9]].9[9[9[9[9]]]]a',
        ])->hint('(eg. 49.2.66200N)') ?>
        <?= $form->field($location, 'lng_ddm')->widget(MaskedInput::classname(), [
            'mask' =>  '9[9[9]].9[9[9]].9[9[9[9[9]]]]a',
        ])->hint('(eg. 122.21.73060W)') ?>

        <?= $form->field($model, 'state_id')->dropDownList(States::listData()) ?>
        <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>