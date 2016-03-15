<?php

namespace app\modules\frontend\controllers\reports;

use app\assets\ReportAsset;
use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\search\Record as RecordSearch;
use app\modules\frontend\models\report\Record;
use app\widgets\report\filters\Filters;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use app\components\Pdf;

class RenderPdfAction extends Action
{
    public $attributes;

    public function init()
    {
        $this->setLayout('pdf');
    }

//    public function beforeRun()
//    {
//        $view = $this->controller()->getView();
//        ReportAsset::register($view);
//        return true;
//    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $model = new RecordSearch();

        $dataProvider = $model->search($this->attributes);
//        $this->controller()->renderPartial('privacy'),
        // get your HTML raw content without any layouts or scripts
        $content = $this->controller()->renderPartial('violationsByDate', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);

        $header = $this->controller()->renderPartial('partials/_header');

        $footer = '<img src="" />';

        $content = $header . $content . $footer;

//        return $content;
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            'styles' => ['@app/web/css/pdf.css'],
            // your html content input
            'content' => $content,
        ]);

        return $pdf->render();
    }

    /**
     * RecordFilter $model
     * @param RecordFilter $model
     * @return string
     * @throws \Exception
     */
    private function setAside(RecordFilter $model)
    {
        return Yii::$app->view->params['aside'] = Filters::widget([
            'model' => $model,
            'action' => Yii::$app->controller->action->id,
        ]);
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    private function setPageTitle()
    {
        $title = Yii::t('app', 'Report');

        return $this->controller()->view->title = $title;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }
}