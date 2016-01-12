<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Owners */

$this->title = 'Update Owners: ' . ' ' . $model->id;

?>
<div class="owners-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
