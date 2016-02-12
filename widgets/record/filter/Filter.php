<?php

namespace app\widgets\record\filter;

use Yii;
use yii\base\Widget;
use app\widgets\record\filter\assets\FilterAsset;
use app\modules\frontend\models\base\RecordFilter;

class Filter extends Widget
{
    /**
     * @var bool
     */
    public $advanced_mode = false;

    /**
     * @var RecordFilter
     */
    public $model;

    public function init()
    {
        FilterAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', [
            'advanced' => $this->advanced_mode,
            'filters' => [
                'created_at' => $this->model->getCreatedAtFilters(),
                'statuses' => $this->model->getStatusFilters(Yii::$app->controller->action->id),
                'authors' => $this->model->getAuthorFilters(),
            ],
            'model' => $this->model
        ]);
    }

}