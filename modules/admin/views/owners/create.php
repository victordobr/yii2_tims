<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Owner */

$this->title = 'Create Owner';

?>
<div class="owner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
