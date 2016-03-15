
<?php foreach ($providers as $parent_id => $dataProvider): ?>
    <div class="<?= $class?>">
        <?= $this->render('partials/_table', ['dataProvider' => $dataProvider]); ?>
    </div>
<?php endforeach; ?>
