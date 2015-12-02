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

?>

<span class="btn btn-success fileinput-button">
    <i class="glyphicon glyphicon-plus"></i>
    <span>Add...</span>
    <?= FileUpload::widget([
        'name' => 'image',
        'url' => $uploadUrl,
        'options' => [
            'accept' => $acceptMimeTypes
        ],
        'clientOptions' => [
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'dropZone' => $dropZone,
        ],
        // Also, you can specify jQuery-File-Upload events
        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
        'clientEvents' => [
//        'fileuploadadd'      => "function(e, data) {
//
//                    }",
            'fileuploadprogress' => "function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('.progress-bar').css( 'width', progress + '%');
                        $('.progress-bar span').replaceWith('<span>' + progress + '% ' + 'Uploading file' + '</span>')
                    }",
//        'fileuploadstart'    => "function(e, data) {
//                    }",
            'fileuploaddone' => "function(e, data, jqXHR) {
                            $('.progress-bar').css( 'width', '100%');
                            $('.progress-bar span').replaceWith('<span>100% ' + 'Processing file' + '</span>')
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
                            });

                    }",
            'fileuploadfail' => "function(e, data) {
                        $.notify('Upload failed');
                    }",
        ],
    ]); ?>
    </span>

<div id="progress" class="progress">
    <div class="progress-bar progress-bar-success"><span></span></div>
</div>
