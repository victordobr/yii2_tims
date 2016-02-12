<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\modules\frontend\models\search\Record
 * @var $advanced bool
 * @var $filters array
 */

use kartik\icons\Icon;

?>

<div class="row">

    <div class="panel panel-default panel-record-filter">
        <div class="panel-heading"><?= Yii::t('app', 'Filter By') ?></div>

        <div id="record-search-filter" class="panel-body">

            <?php if ($advanced): ?>
                <div class="row panel-subtitle">
                    <a href="#"><?= Yii::t('app', 'Basic') ?><?= Icon::show('angle-double-down') ?></a>
                </div>
            <?php endif; ?>

            <div class="panel-section<?= !$advanced ? '' : ' hide' ?>">
                <?= $this->render('form/basic', [
                    'model' => $model,
                    'filters' => $filters,
                ]); ?>
            </div>

            <?php if ($advanced): ?>
                <div class="row panel-subtitle">
                    <a href="#"><?= Yii::t('app', 'Advanced') ?><?= Icon::show('angle-double-down') ?></a>
                </div>

                <div class="panel-section">
                    <?= $this->render('form/advanced', [
                        'model' => $model,
                        'filters' => $filters,
                    ]); ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>