<?php
/**
 * @var array $timeline
 * @var int $remaining
 */
?>

<div class="panel panel-default panel-case-timeline">
    <div class="panel-heading">
        <?= Yii::t('app', 'Case timeline') ?>
    </div>

    <div class="panel-body">
        <?php foreach ($timeline as $stage): ?>
            <?= $this->render('stage', ['stage' => $stage]); ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="panel panel-default panel-time-remaining">
    <div class="panel-heading">
        <?= Yii::t('app', 'Time remaining') ?>
    </div>

    <div class="panel-body">
        <span><?= $remaining?> days</span>
    </div>
</div>