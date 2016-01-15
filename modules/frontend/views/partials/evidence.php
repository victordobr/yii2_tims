<?php
/**
 * @var \app\models\base\Evidence $model
 */
?>

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