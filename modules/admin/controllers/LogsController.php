<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\search\Log as LogSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\elasticsearch\ActiveRecord;

/**
 * LogsController implements the CRUD actions for Log model.
 */
class LogsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Log models.
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        try {
            ActiveRecord::getDb()->open();
        }
        catch (Exception $e) {
            throw new NotFoundHttpException('Sorry, logging service is not available now');
        }
        $searchModel = new LogSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
