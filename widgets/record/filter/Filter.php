<?php

namespace app\widgets\record\filter;

use yii\base\Widget;
use app\widgets\record\filter\assets\FilterAsset;

class Filter extends Widget
{
    public $model;

    public function init()
    {
        FilterAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', ['model' => $this->model]);
    }

}