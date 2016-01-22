<?php

namespace app\modules\frontend\controllers\records;

use app\modules\frontend\models\search\Record;
use yii\base\Action;

class ReviewAction extends Action
{

    public function run($id = 0)
    {
        $controller = $this->controller;
        if (!$id) {
            $controller->redirect(['search']);
        }

        return $controller->render('view', [
            'model' => $controller->findModel(Record::className(), $id),
        ]);
    }

}