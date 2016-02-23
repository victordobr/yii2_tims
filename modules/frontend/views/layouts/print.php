<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */
?>

<?php $this->beginPage() ?>

    <!DOCTYPE html >
    <html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta charset="utf-8"/>
        <?php $this->head() ?>
    </head>

    <body style="margin: 0;">

    <div class="col-xs-6 col-xs-offset-2 noprint" style="position: fixed; top: 8px;">
        <div class="row">
            <button class="btn btn-default btn-back"><?= Yii::t('app', 'Back'); ?></button>
            <button class="btn btn-default btn-print pull-right"><?= Yii::t('app', 'Print'); ?></button>
        </div>
    </div>

    <div class="container">
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
    </div>

    </body>
    </html>

<?php $this->endPage() ?>