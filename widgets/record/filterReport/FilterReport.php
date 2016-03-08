<?php

namespace app\widgets\record\filterReport;

use Yii;
use yii\base\Widget;
use app\widgets\record\filterReport\assets\FilterReportAsset;

class FilterReport extends Widget
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