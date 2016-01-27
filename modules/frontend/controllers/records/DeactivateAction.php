<?php

namespace app\modules\frontend\controllers\records;

use app\modules\frontend\controllers\RecordsController;
use Yii;
use yii\base\Action;
use app\modules\frontend\models\search\Record;
use app\modules\frontend\models\form\DeactivateForm;

class DeactivateAction extends Action
{

    public function run($id = 0)
    {
        $controller = $this->controller();
        $record = $controller->findModel(Record::className(), $id);

        $attributes = Yii::$app->request->post('DeactivateForm');
        $action = $attributes['action'];
        $form = new DeactivateForm();
        if(!$form->validateAction($action)){
            return $controller->redirect(['review', 'id' => $record->id]);
        }
        $form->setScenario($action);
        $form->setAttributes(Yii::$app->request->post('DeactivateForm'));

        if ($form->validate()) {
            $success = $form->isRejectAction() ?
                self::record()->rejectDeactivation($record->id, $form->code, $form->description) :
                self::record()->approveDeactivate($record->id);
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