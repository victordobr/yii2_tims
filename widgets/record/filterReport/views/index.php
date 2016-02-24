<?php

use yii\bootstrap\Html;

?>

<div class="row">

    <div class="panel panel-default panel-record-filter">
        <div class="panel-heading"><?= Yii::t('app', 'Filter by') ?></div>

        <div id="record-reports-filter" class="panel-body">

            <div class="panel-section">
                <?= $this->render($view, ['model' => $model,]); ?>
            </div>

        </div>

    </div>

</div>