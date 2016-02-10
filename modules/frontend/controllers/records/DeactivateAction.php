<?php

namespace app\modules\frontend\controllers\records;

use app\modules\frontend\controllers\RecordsController;
use Yii;
use yii\base\Action;
use app\modules\frontend\models\search\Record;
use app\modules\frontend\models\form\DeactivateForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DeactivateAction extends Action
{

    public function run($id = 0)
    {
        $controller = $this->controller();
        $record = $controller->findModel(Record::className(), $id);

        $form = new DeactivateForm();
        $form->setAttributes(Yii::$app->request->post('DeactivateForm'));

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }

        if ($form->validate()) {

            //true
//            var_dump($form->isRejectAction()); die;

            $success = $form->isRejectAction() ?
                self::record()->rejectDeactivation($record->id, Yii::$app->user->id, $form->code, $form->description) :
                self::record()->approveDeactivate($record->id, Yii::$app->user->id);
            if ($success) {
                return $controller->redirect(['search']);
            }
        }

        return $controller->redirect(['review', 'id' => $record->id]);
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

    /**
     * @return RecordsController
     */
    private static function controller()
    {
        return Yii::$app->controller;
    }

}