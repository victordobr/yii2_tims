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
<div class="wrap frontend-wrapper">
    <?php
    yii\bootstrap\NavBar::begin(app\base\Module::getNavBarConfig());

    echo yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => \app\modules\frontend\Module::getNavbarItems(),
    ]);

    yii\bootstrap\NavBar::end();
    ?>

    <div class="container">
        <div class="top-menu">
            <?php
            echo yii\bootstrap\Nav::widget([
                'options' => ['class' => 'nav nav-tabs nav-justified'],
                'items'   => \app\modules\frontend\Module::getMenuItems(),
            ]);
            ?>
        </div>
        <div id="page-loading">
            <div class="show-loading"></div>
            <div class="img-load"></div>
        </div>
        <div class="content">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"><img src="/images/gatekeeper_gate_logo.jpg" alt="gatekeeper gate logo" height="47"></p>

        <p class="pull-right"><img src="/images/splogo-black-dot-back.jpg" alt="splogo" height="47"></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
