<?php

namespace app\modules\frontend\controllers\records;

use app\modules\frontend\controllers\RecordsController;
use app\modules\frontend\models\form\ChangeDeterminationForm;
use Yii;
use yii\base\Action;
use app\modules\frontend\models\search\Record;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ChangeDeterminationAction extends Action
{
    public $attributes;

    public function run($id = 0)
    {
        $controller = $this->controller();
        $request = Yii::$app->request;
        $record = $controller->findModel(Record::className(), $id);

        $form = new ChangeDeterminationForm();

        if ($request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }

        $form->setAttributes($this->attributes);
        if ($form->validate()) {
            $user = Yii::$app->user;
            $success = $form->isRejectAction() ?
                self::record()->rejectViolation($record->id, $user->id, $form->officer_pin, $form->code, $form->description) :
                self::record()->approveViolation($record->id, $user->id, $form->officer_pin) &&
                self::record()->retrieveDMVData($record->id, $user->id); // todo: temporary jump

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