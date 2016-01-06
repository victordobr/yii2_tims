<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PoliceCase */

$this->title = 'Create Police Case';
//$this->params['breadcrumbs'][] = ['label' => 'Cases Listing', 'url' => ['manage']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="police-case-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
