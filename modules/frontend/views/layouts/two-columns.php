<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */
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

    <div class="container">
        <div id="page-loading">
            <div class="show-loading"></div>
            <div class="img-load"></div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="header">BANNER/HEADER</div>
                <div class="top-menu">
                    <?= yii\bootstrap\Nav::widget([
                        'options' => ['class' => 'nav nav-tabs nav-justified'],
                        'items' => \app\modules\frontend\Module::getMenuItems(),
                    ]); ?>
                </div>
                <div class="header-title"><h1><?=$this->title?></h1></div>
            </div>
            <div class="col-md-3">
                <?= \app\widgets\user\info\Info::widget(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <?= $content ?>
            </div>
            <div class="col-md-3">
                <div class="aside">
                    <?= !empty($this->params['aside']) ? $this->params['aside'] : ''; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right"><img src="/images/evidence-investigation.png" alt="evidence & investigation" height="47"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
