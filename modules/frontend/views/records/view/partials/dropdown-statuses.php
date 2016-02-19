<?php
use yii\helpers\Html;

/**
 * @var $statuses array
 */
?>
<div class="form-group form-group-sm">
    <?= Html::dropDownList('Record[status_id]', null, $statuses, [
        'class' => 'form-control',
        'prompt' => Yii::t('app', 'Change record state to'),
    ]) ?>
</div>