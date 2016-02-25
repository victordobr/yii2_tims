<?php

namespace app\widgets\record\update;

use app\widgets\record\update\assets\UpdateButtonAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\Json;

class UpdateButton extends Widget
{
    private $id = 'record-save-changes';

    /**
     * @var string
     */
    public $wrapper;

    /**
     * @var array
     */
    public $forms = [];

    public function init()
    {
        UpdateButtonAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', [
            'id' => $this->id,
            'wrapper' => $this->wrapper,
            'forms' => Json::encode($this->forms),
        ]);
    }

}