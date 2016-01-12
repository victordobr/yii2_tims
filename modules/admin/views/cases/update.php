<?php

use \yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $case app\models\PoliceCase */
/* @var $evidence app\models\Evidence */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Case: ' . ' ' . $case->id;
//$this->params['breadcrumbs'][] = ['label' => 'Police Cases', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="police-case-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        <div class="form-group">

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'required-asterisk'],
            ]); ?>

            <?= $this->render('partials/_filesPart', [
                'evidence' => $evidence,
            ]); ?>

            <?= $this->render('partials/_casePart', [
                'form' => $form,
                'case' => $case,
            ]); ?>

            <?= $this->render('partials/_evidencePart', [
                'form' => $form,
                'evidence' => $evidence,
            ]); ?>

            <?= $this->render('partials/_userPart', [
                'form' => $form,
                'user' => $user,
            ]); ?>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
