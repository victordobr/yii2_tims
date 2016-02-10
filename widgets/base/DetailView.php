<?php
namespace app\widgets\base;

use app\widgets\base\assets\DetailViewAsset;

class DetailView extends \yii\widgets\DetailView
{
    public $title;
    public $footer;

    public function init()
    {
        parent::init();
        DetailViewAsset::register($this->getView());
    }

    public function run()
    {
        echo '<div class="panel panel-default panel-view">';
        if ($this->title) {
            echo '<div class="panel-heading">' . $this->title . '</div>';
        }
        echo '<div class="panel-body">';
        parent::run();
        echo '</div>';
        if ($this->footer) {
            echo '<div class="panel-footer">' . $this->footer . '</div>';
        }
        echo '</div>';
    }

}