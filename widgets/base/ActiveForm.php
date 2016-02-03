<?php
namespace app\widgets\base;

use app\widgets\base\assets\ActiveFormAsset;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $title;
    public $footer;

    public function init()
    {
        ActiveFormAsset::register($this->getView());
        parent::init();

        echo '<div class="panel panel-default panel-form">';
        if ($this->title) {
            echo '<div class="panel-heading">' . $this->title . '</div>';
        }
        echo '<div class="panel-body">';
    }

    public function run()
    {
        parent::run();
        echo '</div>';
        if ($this->footer) {
            echo '<div class="panel-footer">' . $this->footer . '</div>';
        }
        echo '</div>';
    }

}