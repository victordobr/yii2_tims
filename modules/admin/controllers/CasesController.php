<?php

namespace app\modules\admin\controllers;

use app\enums\Role;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\base\Controller;
use app\modules\admin\models\search\PoliceCase;

/**
 * CasesController implements the CRUD actions for PoliceCase model.
 */
class CasesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['manage', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Role::ROLE_ROOT_SUPERUSER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PoliceCase models.
     * @return mixed
     */
    public function actionManage()
    {
        $searchModel = new PoliceCase();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PoliceCase model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(PoliceCase::className(), $id),
        ]);
    }

    /**
     * Creates a new PoliceCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PoliceCase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PoliceCase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(PoliceCase::className(), $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PoliceCase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel(PoliceCase::className(), $id)->delete();

        return $this->redirect(['manage']);
    }

    /**
     * Finds the PoliceCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string|ActiveRecord $modelClass model or model class.
     * @param integer $id
     * @return PoliceCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($modelClass, $id)
    {
        if (($model = PoliceCase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
