<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CaseStatus */

$this->title = 'Create Case Status';
$this->params['breadcrumbs'][] = ['label' => 'Case Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="case-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
