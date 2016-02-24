<?php

namespace app\modules\frontend\controllers\records;

use app\assets\PreviewAsset;
use app\modules\frontend\models\prints\preview\Record;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class PreviewAction extends Action
{
    public $ids;

    public function init()
    {
        parent::init();

        $this->setLayout('preview');
        PreviewAsset::register($this->controller()->getView());
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $model = new Record();

        return $this->controller()->render('print/preview', [
            'provider' => $model->search($this->ids),
        ]);
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

}