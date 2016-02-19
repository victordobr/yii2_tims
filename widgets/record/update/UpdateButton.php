<?php

namespace app\widgets\record\update;

use app\widgets\record\update\assets\UpdateButtonAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\Json;

class UpdateButton extends Widget
{
    /**
     * @var array
     */
    public $elements = [];

    public function init()
    {
        UpdateButtonAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', [
            'elements' => Json::encode($this->elements),
        ]);
    }

}