<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */
app\assets\AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
<head>
    <meta charset="<?= \Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= yii\helpers\Html::csrfMetaTags() ?>
    <title><?= yii\helpers\Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    yii\bootstrap\NavBar::begin(app\base\Module::getNavBarConfig());

    echo yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => \app\modules\admin\Module::getMenuItems(),
    ]);

    yii\bootstrap\NavBar::end();
    ?>

    <div class="container">
        <div id="page-loading">
            <div class="show-loading"></div>
            <div class="img-load"></div>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
