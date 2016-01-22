<?php

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Record */

$this->title = "Record #: $record->id";
?>
<div class="record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_filesPart', [
        'record' => $record,
    ]); ?>

    <div class="record-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php if (isset($owner)): ?>
            <h2>Owner Information</h2>
            <?= $this->render('partials/_ownerPart', [
                'form' => $form,
                'owner' => $owner,
            ]); ?>
        <?php endif; ?>

            <h2>Case Information</h2>

            <?= $this->render('partials/_recordPart', [
                'form' => $form,
                'record' => $record,
            ]); ?>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="user-details">
            <div class="well well-sm">
                <p><strong>Uploaded By: </strong><?= $userFullName; ?></p>
            </div>
        </div>

    </div>

</div>

