<?php
/**
 * @var $this View
 * @author Alex Makhorin
 */
use \yii\helpers\Html;
use \yii\web\View;
use \dosamigos\fileupload\FileUpload;
?>

<?= FileUpload::widget([
    'name'          => 'image',
    'url'           => $uploadUrl,
    'options'       => [
        'accept' => $acceptMimeTypes
    ],
    'clientOptions' => [
        'maxFileSize'  => $maxFileSize,
        'maxChunkSize' => $maxChunkSize,
        'dropZone'     => $dropZone,
    ],
    // Also, you can specify jQuery-File-Upload events
    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
    'clientEvents'  => [
        'fileuploadadd'      => "function(e, data) {

                        var allowedTypes = " . json_encode(explode(',', $acceptMimeTypes)) . ";

                        if (data.files == undefined || $.inArray(data.files[0].type, allowedTypes) == -1) {
                            $.notifyDanger($.yiit('galleryManager/main', 'Invalid file type'), 5000);
                            return false;
                        }

                        var allowUpload = " . (int)(Yii::$app->params['common.available.space'] >= Yii::$app->get('service|gallery')->getUsedSpace(Yii::$app->user->id)) . ";
                        var isAdmin = " . (int)Yii::$app->user->isAdmin() . ";
                        if (isAdmin) {} else if (allowUpload) {} else {
                            $.notifyDanger($.yiit('galleryManager/main', 'Upload limit is exceeded'), 5000);
                            return false;
                        }
                    }",
        'fileuploadprogress' => "function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress-modal .progress-bar').css( 'width', progress + '%');
                        $('#progress-modal .progress-bar span').replaceWith('<span>' + progress + '% ' + $.yiit('galleryManager/main', 'Uploading file') + '</span>')
                    }",
        'fileuploadstart'    => "function(e, data) {
                        $('#progress-modal').modal('show');
                    }",
        'fileuploaddone'     => "function(e, data, jqXHR) {
                        data.sum = '';
                        var def = md5_file(data.files[0]);
                        def.done(function(){
                            if (!def.sum) {
                                $.notifyDanger($.yiit('app', 'Could not read the file'), 5000);
                            } else {
                                data.sum = def.sum;
                            }
                            $('#progress-modal .progress-bar').css( 'width', '100%');
                            $('#progress-modal .progress-bar span').replaceWith('<span>100% ' + $.yiit('galleryManager/main', 'Processing file') + '</span>')
                            $.ajax({
                                type: 'POST',
                                url: '{$handleUrl}',
                                data: {
                                    file: data.jqXHR.responseText,
                                    sum: data.sum
                                },
                                dataType: 'json',
                                error: function(jqXHR, textStatus, errorThrown){
                                    $('#progress-modal').modal('hide');
                                    $.notifyDanger('" . \Yii::t('galleryManager/main', 'Error occurred') . ": ' + jqXHR.responseText, 5000);
                                }
                            }).done(function (resp) {
                                $.pjax.reload({
                                    container:'#pjaxMainGallery',
                                    replace: false,
                                    method: 'get'
                                });
                                $('#progress-modal').modal('hide');
                                $.notifySuccess('" . \Yii::t('galleryManager/main', 'Upload complete') . "');
                            });
                        });
                    }",
        'fileuploadfail'     => "function(e, data) {
                        $('#progress-modal').modal('hide');
                        $.notifyDanger('" . \Yii::t('galleryManager/main', 'Upload failed') . "');
                    }",
    ],
]); ?>
