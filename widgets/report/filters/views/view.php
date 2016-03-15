<?php

use yii\bootstrap\Html;

?>

<div class="row" xmlns="http://www.w3.org/1999/html">

    <div class="panel panel-default panel-record-filter">
        <div class="panel-heading"><?= Yii::t('app', 'Filter by') ?></div>

        <div id="record-reports-filter" class="panel-body">

                <?= $this->render('form/date', ['model' => $model]); ?>

        </div>

        <div class="panel-footer">
            <div class="row">
                <?= Html::a(Yii::t('app', 'Print Report'), '#' , ['class' => 'btn btn-default', 'role' => 'button']) ?>
            </div>
        </div>

    </div>

</div>