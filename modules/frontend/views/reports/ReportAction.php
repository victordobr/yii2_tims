
<?php foreach ($providers as $parent_id => $dataProvider): ?>

    <?= $this->render('partials/_table', ['dataProvider' => $dataProvider]); ?>

<?php endforeach; ?>
