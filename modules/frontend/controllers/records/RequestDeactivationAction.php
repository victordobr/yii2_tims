<?php

namespace app\modules\frontend\controllers\records;

use Yii;
use yii\base\Action;
use app\modules\frontend\models\search\Record;
use app\modules\frontend\models\form\DeactivateForm;

class RequestDeactivationAction extends Action
{

    public function run($id = 0)
    {
        $controller = $this->controller;
        $record = $controller->findModel(Record::className(), $id);

        $form = new DeactivateForm();
        $form->setAttributes(Yii::$app->request->post('DeactivateForm'));

        if ($form->validate() && Yii::$app->record->requestDeactivation($record->id, $form->code,  $form->description)) {
            return $controller->redirect(['search']);
        }

        return $controller->redirect(['review', 'id' => $record->id]);
    }

}