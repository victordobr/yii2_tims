<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Owners;
use app\modules\admin\models\search\Owners as OwnersSearch;
use \app\modules\admin\base\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OwnersController implements the CRUD actions for Owners model.
 */
class OwnersController extends Controller
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
     * Lists all Owners models.
     * @return mixed
     */
    public function actionManage()
    {
        $searchModel = new OwnersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Owners model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(Owners::className, $id),
        ]);
    }

    /**
     * Creates a new Owners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Owners();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Owners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(Owners::className, $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Owners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel(Owners::className, $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Owners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string|ActiveRecord $modelClass model or model class.
     * @param integer $id
     * @return Owners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($modelClass, $id)
    {
        if (($model = Owners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
