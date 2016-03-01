<?php

$this->title = \Yii::t('app','Create Setting');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="setting-create">

    <?= $this->render('_form',['model' => $model]) ?>

</div>
