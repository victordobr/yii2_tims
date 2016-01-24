<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Record;
use app\models\User;
use app\modules\admin\models\search\Record as RecordSearch;

use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\base\Controller;

/**
 * RecordsController implements the CRUD actions for Record model.
 */
class RecordsController extends Controller
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
     * Lists all Record models.
     * @return mixed
     */
    public function actionManage()
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(Record::className(), $id),
        ]);
    }

    /**
     * Updates an existing PoliceCase, Evidence and User model.
     * If update is successful, the browser will be redirected to the 'manage' page.
     * @param ineger $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $record = Record::findOne($id);

        $owner = $record->owner;

        $userFullName = User::findOne($record->user_id)->getFullName();

        if (!isset($record)) {
            throw new NotFoundHttpException("The record was not found.");
        }

        if ($record->load(Yii::$app->request->post())) {

            if ($record->save()) {
                if(!empty($owner) && $owner->load(Yii::$app->request->post()) && $owner->validate()) {
                    $owner->save();
                }
            }

//            VarDumper::dump($record->attributes, 10, true);
//            VarDumper::dump($record->getErrors(), 10, true);
//            die;

            return $this->redirect(['records/manage']);
        }
        return $this->render('update', [
            'record' => $record,
            'owner' => $owner,
            'userFullName' => $userFullName,
        ]);
    }

    /**
     * Deletes an existing Record model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel(Record::className(), $id)->delete();

        return $this->redirect(['manage']);
    }
}
