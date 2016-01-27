<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\frontend\models\search\PoliceCase $model
 */

use \yii\helpers\Html;
use \app\models\User;
//use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = \Yii::t('app', ' ');
$clearLabel = \Yii::t('app', 'Clear Filters');

$this->registerJsFile('http://maps.googleapis.com/maps/api/js');
\app\assets\PrintAsset::register($this);
?>

<div class="user-index">

    <div class="header-title">

    </div>

    <div class="white-background">

        <div class="center noprint"><a href="javascript:window.print();">Print</a></div>
        <?php
        yii\widgets\Pjax::begin([
            'id' => 'pjax-frontend-search',
            'timeout' => false,
            'enablePushState' => false,
        ]);
        ?>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'print/preview',

        ]);?>

