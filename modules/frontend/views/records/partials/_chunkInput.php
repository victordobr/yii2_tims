<?php
/**
 * @var $this View
 * @var string $attribute
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

$attributeHidden = $attribute . 'Id';
?>

<div class="form-group chunk-upload-input required">
    <label class="col-lg-3 control-label"
           for="record-<?= $attribute ?>"><?= $model->getAttributeLabel($attribute) ?> </label>

    <div style="float: left; padding-left: 15px; padding-right: 15px; position: relative;">
                <span class="btn btn-default fileinput-button" style="float: left">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add File...</span>
                    <?= FileUpload::widget([
                        'id' => $attribute,
                        'name' => 'image',
                        'url' => $uploadUrl,
                        'options' => [
                            'accept' => $acceptMimeTypes,
//                            'style' => 'float: left;',
                        ],
                        'clientOptions' => [
                            'maxFileSize' => $maxFileSize,
                            'maxChunkSize' => $maxChunkSize,
                            'dropZone' => $dropZone,
                        ],
                        'clientEvents' => [
                            'fileuploadadd' => "function(e, data) {
                            $('#progress_{$attribute}').show();
                        }",
                            'fileuploadprogress' => "function(e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $('#progress_{$attribute} .progress-bar').css( 'width', progress + '%');
                            $('#progress_{$attribute} .progress-bar span').replaceWith('<span>' + progress + '% ' + 'Uploading file' + '</span>')
                        }",
                            'fileuploaddone' => "function(e, data, jqXHR) {
                            $('#progress_{$attribute} .progress-bar').css( 'width', '100%');
                            $('#progress_{$attribute} .progress-bar span').replaceWith('<span>100% ' + 'Processing file' + '</span>')
                            $.ajax({
                                type: 'POST',
                                url: '{$handleUrl}',
                                data: {
                                    file: data.jqXHR.responseText
                                },
                                dataType: 'json',
                                error: function(jqXHR, textStatus, errorThrown){
                                    $.notify('Error occurred' + jqXHR.responseText, 5000);
                                }
                            }).done(function (resp) {
                                $.notify('Upload complete', 'success');
                                  $('input[name=\"Record[{$attributeHidden}]\"]').val(resp.id);
                            });

                    }",
                            'fileuploadfail' => "function(e, data) {
                        $.notify('Upload failed');
                    }",
                        ],
                    ]); ?>
                </span>
    </div>
    <div class="col-lg-5" style="padding: 2px 0 0;width: 135px;">
        <div id="progress_<?= $attribute ?>" class="progress" style="display: none">
            <div class="progress-bar progress-bar-success"><span></span></div>
        </div>
    </div>

        <?php echo $form->field($model, $attributeHidden, [
            'options' => [
                'class' => 'hidden-upload-wrapper'
            ],
        ])->hiddenInput()->label(false) ?>

</div>