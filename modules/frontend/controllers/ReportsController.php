<?php

namespace app\modules\frontend\controllers;

use app\modules\frontend\controllers\reports\ReportDetailsAction;
use Yii;
use app\enums\report\ReportType;
use app\modules\frontend\controllers\reports\IndexAction;
use app\modules\frontend\controllers\reports\ViolationsByDateAction;
use \app\modules\frontend\base\Controller;
use yii\data\ArrayDataProvider;

/**
 * RecordsController implements the actions for Record model.
 */
class ReportsController extends Controller
{

    public function actions()
    {
        $request = Yii::$app->request;

        return [
            'violations-by-date' => [
                'class' =>  ViolationsByDateAction::className(),
            ],



            'report-details' => [
                'class' =>  ReportDetailsAction::className(),
                'attributes' => $request->get('Record'),
            ],


        ];
    }

    public function actionIndex()
    {
        $allItems = ReportType::createItems();

        foreach ($allItems as $parent_id => $item) {
            $providers[] = new ArrayDataProvider([
                'Models' => $item,
                'id' => $parent_id,
                'pagination' => false,
            ]);
        }

        return $this->render('ReportAction', [
            'providers' => $providers,
        ]);
    }

//    private function setPageTitle()
//    {
//        return $this->controller()->view->title = Yii::t('app', 'Search Panel - List of uploaded cases');
//    }
//    public function afterAction($action, $result)
//    {
//        $result = parent::afterAction($action, $result);
//        // your custom code here
//        return $result;
//    }


}
