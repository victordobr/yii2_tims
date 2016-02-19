<?php
/**
 * @var string $class
 * @var string $icon
 * @var string $text
 */
?>

<div class="text-center<?= !empty($class) ? ' ' . $class : '' ?>">
    <div class="wrapper-icon"><?= $icon ?></div>
    <div class="wrapper-text"><?= $text ?></div>
</div>