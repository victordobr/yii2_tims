<?php
/**
 * @var array $timeline
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('app', 'Case timeline') ?>
    </div>

    <div class="panel-body">
        <?php foreach ($timeline as $stage): ?>
            <?= $this->render('stage', ['stage' => $stage]); ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('app', 'Time remaining') ?>
    </div>

    <div class="panel-body">
        7 days
    </div>
</div>