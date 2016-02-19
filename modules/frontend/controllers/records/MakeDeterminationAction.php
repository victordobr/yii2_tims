<?php

namespace app\modules\frontend\controllers\records;

use app\models\User;
use app\modules\frontend\controllers\RecordsController;
use app\modules\frontend\models\form\MakeDeterminationForm;
use Yii;
use yii\base\Action;
use app\modules\frontend\models\search\Record;
use app\modules\frontend\models\form\DeactivateForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class MakeDeterminationAction extends Action
{
    public $attributes;

    public function run($id = 0)
    {
        $controller = $this->controller();
        $request = Yii::$app->request;
        $record = $controller->findModel(Record::className(), $id);

        $user = User::findOne(Yii::$app->user->id);
        $form = new MakeDeterminationForm([
            'currentOfficerPin' => $user->officer_pin,
        ]);

        if ($request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }

        $form->setAttributes($this->attributes);
        if ($form->validate()) {
            $user = Yii::$app->user;
            $success = $form->isRejectAction() ?
                self::record()->rejectViolation($record->id, $user->id, $form->code, $form->description) :
                self::record()->approveViolation($record->id, $user->id);
            if ($success) {
                return $controller->redirect(['SearchList']);
            }
        }

        return $controller->redirect(['ReviewView', 'id' => $record->id]);
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