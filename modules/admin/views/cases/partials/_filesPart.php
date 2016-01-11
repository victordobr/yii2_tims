
<h2>Files</h2>

<?php if ($evidence->imageOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->imageOverviewCamera->url,
        'type' => $evidence->imageOverviewCamera->file_type,
        'title' => $evidence->getAttributeLabel('imageOverviewCamera'),
    ]); ?>
<?php endif; ?>

<?php if ($evidence->imageLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->imageLpr->url,
        'type' => $evidence->imageLpr->file_type,
        'title' => $evidence->getAttributeLabel('imageLpr'),
    ]); ?>
<?php endif; ?>

<?php if ($evidence->videoLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->videoLpr->url,
        'type' => $evidence->videoLpr->file_type,
        'title' => $evidence->getAttributeLabel('videoLpr'),
    ]); ?>
<?php endif; ?>

<?php if ($evidence->videoOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'url' => $evidence->videoOverviewCamera->url,
        'type' => $evidence->videoOverviewCamera->file_type,
        'title' => $evidence->getAttributeLabel('videoOverviewCamera'),
    ]); ?>
<?php endif; ?>