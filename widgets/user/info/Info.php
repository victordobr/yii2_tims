<?php

namespace app\widgets\user\info;

use yii\base\Widget;
use app\widgets\user\info\assets\InfoAsset;

class Info extends Widget
{

    public function init()
    {
        InfoAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', []);
    }

}