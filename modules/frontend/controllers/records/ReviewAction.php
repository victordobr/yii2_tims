<?php

namespace app\modules\frontend\controllers\records;

use app\models\Record;
use yii\base\Action;
use yii\helpers\VarDumper;

class ReviewAction extends Action
{

    public function run($id = 0)
    {
        $controller = $this->controller;
        if (!$id) {
            $controller->redirect(['search']);
        }

        return $controller->render('review', [
            'model' => $controller->findModel(Record::className(), $id),
        ]);
    }

}