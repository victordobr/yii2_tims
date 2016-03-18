<?php

namespace app\widgets\report\filters;

use Yii;
use yii\base\Widget;
use app\widgets\report\filters\assets\FilterReportAsset;

class Filters extends Widget
{
    const FILTER_DATE_RANGE = 1;
    const FILTER_BUS_NUMBER = 2;
    const FILTER_AUTHOR = 3;
    const FILTER_VIDEO_ANALYST = 3;
    const FILTER_POLICE_OFFICER  = 4;
    const FILTER_PRINT_OPERATOR = 5;

    public $model;
    public $mode;

    public function init()
    {
        FilterReportAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('view', [
            'model' => $this->model,
            'mode' => $this->mode,
        ]);
    }

}