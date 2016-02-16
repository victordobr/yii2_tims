<?php
namespace app\widgets\base;

use app\widgets\base\assets\GridViewAsset;

class GridView extends \kartik\grid\GridView
{

    public function init()
    {
        parent::init();
        GridViewAsset::register($this->getView());
    }

}