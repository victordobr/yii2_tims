<?php
/**
 * @var array $stage
 */
?>

<div class="tl-stage<?= !$stage['is_done'] ? '' : ' tl-done' ?>">
    <span class="tl-label"><?= $stage['label'] ?></span>
    <span class="tl-date"><?= $stage['date'] ?></span>
</div>