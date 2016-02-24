<?php

namespace app\widgets\record\filterReport;

use Yii;
use yii\base\Widget;
use app\widgets\record\filterReport\assets\FilterReportAsset;

class FilterReport extends Widget
{
    public $model;
    public $action;

    public function init()
    {
        FilterReportAsset::register($this->getView());
    }

    function run()
    {
        return $this->renderFilter($this->action);
    }
//TODO
    private function renderFilter($action) {
        switch ($action) {
            case 'report-view':
                return $this->render('view', [
                    'model' => $this->model,
                    'view' => 'form/reportView',
                ]);
            case 'violations-by-date':
                $view = 'form/byDate';
                break;
            case 'violations-by-school-bus':
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