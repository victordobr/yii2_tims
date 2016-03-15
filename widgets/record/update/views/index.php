<?php
/**
 * @var string $id
 * @var string $wrapper
 * @var string $forms
 */
?>

<div class="form-group text-center">
    <button id="<?= $id ?>" class="btn btn-lg btn-default" data-wrapper="<?= $wrapper ?>" data-forms=<?= $forms ?>><?= Yii::t('app', 'Save changes') ?></button>
</div>