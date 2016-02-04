<?php
/**
 * @var \app\modules\frontend\models\search\Record $model
 */
?>

<?php if ($model->imageLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'text' => Yii::t('app', 'LPR IMG'),
        'url' => $model->imageLpr->url,
        'type' => $model->imageLpr->file_type,
        'title' => $model->getAttributeLabel('imageLpr'),
        'mime' => $model->imageLpr->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($model->videoLpr): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'text' => Yii::t('app', 'LPR VID'),
        'url' => $model->videoLpr->url,
        'type' => $model->videoLpr->file_type,
        'title' => $model->getAttributeLabel('videoLpr'),
        'mime' => $model->videoLpr->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($model->imageOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'text' => Yii::t('app', 'OVR IMG'),
        'url' => $model->imageOverviewCamera->url,
        'type' => $model->imageOverviewCamera->file_type,
        'title' => $model->getAttributeLabel('imageOverviewCamera'),
        'mime' => $model->imageOverviewCamera->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($model->videoOverviewCamera): ?>
    <?= app\widgets\mediaPopup\MediaPopup::widget([
        'text' => Yii::t('app', 'OVR VID'),
        'url' => $model->videoOverviewCamera->url,
        'type' => $model->videoOverviewCamera->file_type,
        'title' => $model->getAttributeLabel('videoOverviewCamera'),
        'mime' => $model->videoOverviewCamera->mime_type,
    ]); ?>
<?php endif; ?>

<?php if ($model->lat && $model->lng): ?>
    <?= app\widgets\mapPopup\MapPopup::widget([
        'text' => Yii::t('app', 'MAP'),
        'latitude' => $model->lat,
        'longitude' => $model->lng,
    ]); ?>
<?php endif; ?>