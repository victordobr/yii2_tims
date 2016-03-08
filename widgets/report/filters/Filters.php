<?php

namespace app\widgets\report\filters;

use Yii;
use yii\base\Widget;
use app\widgets\record\filterReport\assets\FilterReportAsset;

class Filters extends Widget
{
    public $model;
    public $mode;

    public function init()
    {
        FilterReportAsset::register($this->getView());
    }

    function run()
    {
        return $this->renderFilter($this->mode);
    }

    private function renderFilter($mode) {
        return $this->render('view', [
            'model' => $this->model,
        ]);
        switch ($mode) {
            case 1:
                return $this->render('view', [
                    'model' => $this->model,
                    'view' => 'form/reportView',
                ]);
            case 2:
                $view = 'form/byDate';
                break;
            case 3:
                $view = 'form/bySchoolBus';
                break;
            default:
                return false;
        }
        return $this->render('index', [
            'model' => $this->model,
            'view' => $view,
        ]);
    }

}