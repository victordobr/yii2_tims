<?php
namespace app\widgets\base;

use app\widgets\base\assets\DetailViewAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DetailView extends \yii\widgets\DetailView
{
    const MODE_ONE_COLUMN = 1;
    const MODE_TWO_COLUMNS = 2;

    private $mode;

    public $max_rows;
    public $editable = false;

    public $title;
    public $aside;
    public $footer;

    public function init()
    {
        parent::init();
        $this->initColumns();

        DetailViewAsset::register($this->getView());
    }

    private function initColumns()
    {
        return $this->mode = !empty($this->max_rows) || !empty($this->aside) ?
            self::MODE_TWO_COLUMNS : self::MODE_ONE_COLUMN;
    }

    private function isOneColumnMode()
    {
        return $this->mode == self::MODE_ONE_COLUMN;
    }

    public function run()
    {
        echo '<div class="panel panel-default panel-view">';
        if ($this->title) {
            $class = 'panel-heading';
            if ($this->editable) {
                $class .= ' panel-heading-editable';
            }
            echo '<div class="' . $class . '">';
            echo $this->title;
            echo '</div>';
        }

        echo '<div class="panel-body">';
        echo '<div class="row">';

        echo !$this->isOneColumnMode() ? '<div class="col-sm-6">' : '<div class="col-sm-12">';
        $this->renderAttributes();
        echo '</div>';

        if (!$this->isOneColumnMode()) {
            echo '<div class="col-sm-6">';
            if (!empty($this->aside)) {
                echo $this->aside;
            } else {
                $this->renderAttributes();
            }
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';

        if ($this->footer) {
            echo '<div class="panel-footer">' . $this->footer . '</div>';
        }
        echo '</div>';
    }

    public function renderAttributes()
    {
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttribute($attribute, $i++);
            if ($this->max_rows && $this->max_rows == $i) {
                break;
            } else {
                unset($this->attributes[$i - 1]);
            }
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'table');
        echo Html::tag($tag, implode("\n", $rows), $options);
    }

}