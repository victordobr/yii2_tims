<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\Setting;
use app\modules\admin\models\search\Setting as SettingSearch;
use yii\web\NotFoundHttpException;


/**
 * SiteinfoController implements the CRUD actions for Setting model.
 *
 * @author Vitalii Fokov
 */
class SettingsController extends \pheme\settings\controllers\DefaultController
{
    public $layout = 'main';
    /**
     * Defines the controller behaviors
     * @return array
     */
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
     * Lists all Settings.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data = Setting::find()->select('section')->distinct()->where(['<>', 'section', ''])->all();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data,
        ]);
    }

    /**
     * Creates a new Setting.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting(['active' => 1]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/settings/index']);
        }
        // rev: else excessively
        else {
            return $this->render('create', [
                    'model' => $model,
                ]
            );
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/settings/index']);
        }

        return $this->render('update', [
                'model' => $model,
            ]
        );
    }

    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
            ]
        );
    }

    protected function findModel($id)
    {
        if (is_null($model = Setting::findOne($id))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}


