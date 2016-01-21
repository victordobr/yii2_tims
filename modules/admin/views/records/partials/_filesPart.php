
<?php if ($record->imageOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $record->imageOverviewCamera->url,
        'type' => $record->imageOverviewCamera->file_type,
        'title' => $record->getAttributeLabel('imageOverviewCamera'),
        'mime' => $record->imageOverviewCamera->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($record->imageLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $record->imageLpr->url,
        'type' => $record->imageLpr->file_type,
        'title' => $record->getAttributeLabel('imageLpr'),
        'mime' => $record->imageLpr->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($record->videoLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $record->videoLpr->url,
        'type' => $record->videoLpr->file_type,
        'title' => $record->getAttributeLabel('videoLpr'),
        'mime' => $record->videoLpr->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($record->videoOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $record->videoOverviewCamera->url,
        'type' => $record->videoOverviewCamera->file_type,
        'title' => $record->getAttributeLabel('videoOverviewCamera'),
        'mime' => $record->videoOverviewCamera->mime_type,
    ]); ?>
<?php endif; ?>