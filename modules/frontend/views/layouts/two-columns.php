<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;
use yii\helpers\Url;
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

    <header>
        <div class="container">
            <?= \app\widgets\user\info\Info::widget(); ?>

            <?= Html::tag('h1', Yii::t('app', '{logo} Traffic Infraction Management System', ['logo' => Html::tag('span', 'TIMS', ['class' => 'title-abbr'])])); ?>
        </div>
        <div class="sub-title">
            <div class="container">
                <div class="control-group pull-right">
                    <?= Html::a('User profile', Url::to('/frontend/default/profile'))?>
                    <?php if(Yii::$app->user->hasRole([\app\enums\Role::ROLE_ROOT_SUPERUSER])):?>
                        <?= Html::a('Admin portal', Url::to('/admin/users/manage'))?>
                    <?php endif;?>
                    <?= Html::a('Logout', Url::to('/logout'))?>
                </div>

                <?= Html::tag('h2', Yii::t('app', 'Jones County, Georgia')); ?>
            </div>
        </div>
    </header>

    <div class="container">
        <div id="page-loading">
            <div class="show-loading"></div>
            <div class="img-load"></div>
        </div>

        <div class="row">
            <div class="col-md-9">
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
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
