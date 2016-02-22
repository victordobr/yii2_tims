
<div class="row">
    <div class="panel panel-default panel-record-reports-filter">
        <div class="panel-heading"><?= Yii::t('app', 'Filter By') ?></div>
        <div id="record-reports-filter" class="panel-body">
            <?= $this->render('_filter', ['model' => $model]); ?>
        </div>
    </div>
</div>
