<?php

use \yii\helpers\Html;
use \yii\web\View;
use \dosamigos\fileupload\FileUpload;
use yii\bootstrap\ActiveForm;
use \kato\VideojsWidget;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Evidence */

$this->title = 'Update Evidence: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Evidences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evidence-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="evidence-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'case_id')->textInput() ?>

        <?= $form->field($model, 'user_id')->textInput() ?>


        <h2>Photo Video Evidence</h2>

        <?= app\widgets\mediaPopup\MediaPopup::widget([
            'url' => $model->imageOverviewCamera->url,
            'type' => $model->imageOverviewCamera->file_type,
        ])

        ?>

        <?= app\widgets\mediaPopup\MediaPopup::widget([
            'url' => $model->imageLpr->url,
            'type' => $model->imageLpr->file_type,
        ])
        ?>

        <?= app\widgets\mediaPopup\MediaPopup::widget([
            'url' => $model->videoLpr->url,
            'type' => $model->videoLpr->file_type,

        ])

        ?>

        <?= app\widgets\mediaPopup\MediaPopup::widget([
            'url' => $model->videoOverviewCamera->url,
            'type' => $model->videoOverviewCamera->file_type,
        ])

        ?>

        <?= $form->field($model, 'license')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'state_id')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>

</div>
