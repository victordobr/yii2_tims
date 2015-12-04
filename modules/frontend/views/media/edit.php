<?php

use \yii\helpers\Html;
use \yii\web\View;
use \dosamigos\fileupload\FileUpload;
use yii\bootstrap\ActiveForm;
use \kato\VideojsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Evidence */

$this->title = 'Update Evidence: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Evidences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evidence-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="preview-block">
        <?= VideojsWidget::widget([
            'options' => [
                'class' => 'video-js vjs-default-skin vjs-big-play-centered',
                'controls' => true,
                'preload' => 'auto',
                'width' => '250',
            ],
            'tags' => [
                'source' => [
                    [
                        'src' => Yii::$app->media->createMediaUrl($model->video_lpr),
                    ],
                ],
            ],
            'multipleResolutions' => false,
        ]);
        ?>
    </div>
    <div class="preview-block">
        <?= VideojsWidget::widget([
            'options' => [
                'class' => 'video-js vjs-default-skin vjs-big-play-centered',
                'controls' => true,
                'preload' => 'auto',
                'width' => '250',
            ],
            'tags' => [
                'source' => [
                    [
                        'src' => Yii::$app->media->createMediaUrl($model->video_overview_camera),
                    ],
                ],
            ],
            'multipleResolutions' => false,
        ]);
        ?>
    </div>
    <div class="evidence-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'case_id')->textInput() ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'image_lpr')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'image_overview_camera')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'state_id')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
