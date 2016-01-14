
<h2>Files</h2>

<?php if ($evidence->imageOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->imageOverviewCamera->url,
        'type' => $evidence->imageOverviewCamera->file_type,
        'title' => $evidence->getAttributeLabel('imageOverviewCamera'),
        'mime' => $evidence->imageOverviewCamera->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($evidence->imageLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->imageLpr->url,
        'type' => $evidence->imageLpr->file_type,
        'title' => $evidence->getAttributeLabel('imageLpr'),
        'mime' => $evidence->imageLpr->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($evidence->videoLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->videoLpr->url,
        'type' => $evidence->videoLpr->file_type,
        'title' => $evidence->getAttributeLabel('videoLpr'),
        'mime' => $evidence->videoLpr->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($evidence->videoOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->videoOverviewCamera->url,
        'type' => $evidence->videoOverviewCamera->file_type,
        'title' => $evidence->getAttributeLabel('videoOverviewCamera'),
        'mime' => $evidence->videoOverviewCamera->mime_type,
    ]); ?>
<?php endif; ?>