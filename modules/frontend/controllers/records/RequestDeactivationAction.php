<?php

namespace app\modules\frontend\controllers\records;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\modules\frontend\models\search\Record;
use app\modules\frontend\models\form\RequestDeactivateForm;

class RequestDeactivationAction extends Action
{

    public function run($id = 0)
    {
        $controller = $this->controller;
        $record = $controller->findModel(Record::className(), $id);

        $form = new RequestDeactivateForm();
        $form->setAttributes(Yii::$app->request->post('RequestDeactivateForm'));


        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }


        if ($form->validate() && Yii::$app->record->requestDeactivation($record->id, Yii::$app->user->id, $form->code,  $form->description)) {
            return $controller->redirect(['search']);
        }

        return $controller->redirect(['review', 'id' => $record->id]);
    }

}